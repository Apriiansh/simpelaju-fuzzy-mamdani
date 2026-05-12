<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Penduduk;
use App\Models\Kriteria;
use App\Models\NilaiKriteria;
use App\Services\Fuzzy\MamdaniEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    protected $fuzzyEngine;
    protected $inputMapper;

    public function __construct(MamdaniEngine $fuzzyEngine, \App\Services\Fuzzy\InputMapperService $inputMapper)
    {
        $this->fuzzyEngine = $fuzzyEngine;
        $this->inputMapper = $inputMapper;
    }

    /**
     * Display a listing of all assessments with full detail columns.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Penilaian::with([
                'penduduk.kelurahan',
                'penduduk.rumah',
                'nilaiKriteria.kriteria',
                'hasilSPK',
            ]);

        if ($user->role === 'operator') {
            $query->whereHas('penduduk', function($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            });
        }

        $penilaian = $query->latest()->paginate(20);

        // Compute average crisp score per kelurahan for stats cards
        $statsQuery = \App\Models\HasilSpk::join('penilaian', 'hasil_spk.penilaian_id', '=', 'penilaian.id')
            ->join('penduduk', 'penilaian.penduduk_id', '=', 'penduduk.id')
            ->join('kelurahan', 'penduduk.kelurahan_id', '=', 'kelurahan.id');

        if ($user->role === 'operator') {
            $statsQuery->where('penduduk.kelurahan_id', $user->kelurahan_id);
        }

        $statsPerKelurahan = $statsQuery->select(
                'kelurahan.nama as kelurahan_nama',
                \Illuminate\Support\Facades\DB::raw('AVG(hasil_spk.nilai_defuzzifikasi) as rata_skor'),
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as total'),
                \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN hasil_spk.kategori_kelayakan = \'LAYAK\' THEN 1 ELSE 0 END) as total_layak')
            )
            ->groupBy('kelurahan.id', 'kelurahan.nama')
            ->orderByDesc('rata_skor')
            ->get();

        return view('penilaian.index', compact('penilaian', 'statsPerKelurahan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $penduduk_id = $request->query('penduduk_id');
        $penduduk = Penduduk::with('rumah')->findOrFail($penduduk_id);

        // Cek akses
        if ($user->role === 'operator' && $penduduk->kelurahan_id !== $user->kelurahan_id) {
            abort(403);
        }

        if (!$penduduk->rumah) {
            return redirect()->route('rumah.create', ['penduduk_id' => $penduduk->id])
                ->with('error', 'Lengkapi data rumah terlebih dahulu sebelum melakukan penilaian.');
        }

        // Auto-map scores for preview if available
        $autoScores = $this->inputMapper->mapToScores($penduduk->rumah);

        $kriteria = Kriteria::all();
        return view('penilaian.create', compact('penduduk', 'kriteria', 'autoScores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'periode' => 'required|string',
            'nilai' => 'nullable|array', // Optional if auto-calculated
            'nilai.*' => 'nullable|numeric',
        ]);

        try {
            DB::beginTransaction();

            $penduduk = Penduduk::with('rumah')->findOrFail($validated['penduduk_id']);
            $scores = $validated['nilai'] ?? $this->inputMapper->mapToScores($penduduk->rumah);

            $penilaian = Penilaian::create([
                'penduduk_id' => $validated['penduduk_id'],
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'periode' => $validated['periode'],
                'tanggal_penilaian' => now(),
                'status' => 'SELESAI', // Match enum in migration
            ]);

            foreach ($scores as $kodeKriteria => $nilaiInput) {
                // If key is code (K1, K2...) find by code, else assume it's ID
                $kriteria = is_numeric($kodeKriteria)
                    ? Kriteria::find($kodeKriteria)
                    : Kriteria::where('kode', $kodeKriteria)->first();

                if ($kriteria) {
                    NilaiKriteria::create([
                        'penilaian_id' => $penilaian->id,
                        'kriteria_id' => $kriteria->id,
                        'nilai_input' => $nilaiInput,
                    ]);
                }
            }

            // TRIGGER FUZZY ENGINE
            $this->fuzzyEngine->calculate($penilaian);

            DB::commit();

            return redirect()->route('penduduk.show', $validated['penduduk_id'])
                ->with('success', 'Penilaian berhasil diproses dengan mesin Fuzzy Mamdani.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses penilaian: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penilaian = Penilaian::findOrFail($id);

        // Hanya bisa hapus jika status masih draft atau dikembalikan
        if (!in_array($penilaian->verifikasi_status, ['draft', 'dikembalikan'])) {
            return back()->with('error', 'Data yang sudah dikirim atau divalidasi tidak dapat dihapus.');
        }

        $penilaian->delete();
        return back()->with('success', 'Data penilaian berhasil dihapus.');
    }

    public function kirimData(Penilaian $penilaian)
    {
        $penilaian->update(['verifikasi_status' => 'dikirim']);
        return back()->with('success', 'Data berhasil dikirim ke Kecamatan.');
    }

    public function verifikasi(Request $request, Penilaian $penilaian)
    {
        $validated = $request->validate([
            'status' => 'required|in:terverifikasi,dikembalikan',
            'catatan' => 'required_if:status,dikembalikan|nullable|string',
        ]);

        $penilaian->update([
            'verifikasi_status' => $validated['status'],
            'catatan_revisi' => $validated['catatan'] ?? null,
        ]);

        return back()->with('success', 'Status verifikasi berhasil diperbarui.');
    }

    public function validasi(Penilaian $penilaian)
    {
        $penilaian->update([
            'verifikasi_status' => 'valid',
            'tanggal_validasi' => now(),
        ]);

        return back()->with('success', 'Data berhasil divalidasi dan dikunci.');
    }

    /**
     * Mass calculate all residents who have house data but no evaluation yet,
     * or refresh existing evaluations.
     */
    public function hitungMassal()
    {
        try {
            $rumahs = \App\Models\Rumah::all();
            $count = 0;

            foreach ($rumahs as $rumah) {
                // Use InputMapperService to map and trigger Mamdani calculation
                // Periode default 2024 (bisa disesuaikan)
                $this->inputMapper->runAssessment($rumah->penduduk_id, date('Y'));
                $count++;
            }

            return back()->with('success', "Berhasil memproses $count data penilaian menggunakan Fuzzy Mamdani.");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal hitung massal: ' . $e->getMessage());
        }
    }
}
