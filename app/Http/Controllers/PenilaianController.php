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
        // Load all penilaian with full relations for the detail table
        $penilaian = Penilaian::with([
                'penduduk.kelurahan',
                'penduduk.rumah',
                'nilaiKriteria.kriteria',
                'hasilSPK',
            ])
            ->latest()
            ->paginate(20);

        // Compute average crisp score per kelurahan for stats cards
        $statsPerKelurahan = \App\Models\HasilSpk::join('penilaian', 'hasil_spk.penilaian_id', '=', 'penilaian.id')
            ->join('penduduk', 'penilaian.penduduk_id', '=', 'penduduk.id')
            ->join('kelurahan', 'penduduk.kelurahan_id', '=', 'kelurahan.id')
            ->select(
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
        $penduduk_id = $request->query('penduduk_id');
        $penduduk = Penduduk::with('rumah')->findOrFail($penduduk_id);
        
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
        //
    }
}
