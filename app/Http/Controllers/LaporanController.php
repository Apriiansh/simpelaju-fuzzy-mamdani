<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\HasilSpk;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Operator Lurah should only see their Kelurahan
        if ($user->role === 'operator') {
            $kelurahans = Kelurahan::where('id', $user->kelurahan_id)->get();
        } else {
            $kelurahans = Kelurahan::all();
        }

        $query = HasilSpk::with(['penilaian.penduduk.kelurahan', 'penilaian.penduduk.rumah'])
            ->join('penilaian', 'hasil_spk.penilaian_id', '=', 'penilaian.id')
            ->join('penduduk', 'penilaian.penduduk_id', '=', 'penduduk.id')
            ->select('hasil_spk.*', 'penduduk.nama_lengkap', 'penduduk.nik', 'penilaian.verifikasi_status');

        // Scoping based on user role
        if ($user->role === 'admin') {
            // Admin can see verified or valid
            $query->whereIn('penilaian.verifikasi_status', ['terverifikasi', 'valid']);
        } else {
            // Camat / Operator only see validated (valid)
            $query->where('penilaian.verifikasi_status', 'valid');
        }

        // Restrict Operator to their own Kelurahan
        if ($user->role === 'operator') {
            $query->where('penduduk.kelurahan_id', $user->kelurahan_id);
        } elseif ($request->filled('kelurahan_id')) {
            $query->where('penduduk.kelurahan_id', $request->kelurahan_id);
        }

        if ($request->filled('status')) {
            $query->where('hasil_spk.kategori_kelayakan', $request->status);
        }

        if ($request->filled('tgl_mulai')) {
            $query->whereDate('penilaian.tanggal_penilaian', '>=', $request->tgl_mulai);
        }

        if ($request->filled('tgl_selesai')) {
            $query->whereDate('penilaian.tanggal_penilaian', '<=', $request->tgl_selesai);
        }

        $query->orderBy('hasil_spk.nilai_defuzzifikasi', 'desc');

        $laporan = $query->paginate(20)->withQueryString();

        return view('laporan.index', compact('laporan', 'kelurahans'));
    }

    public function cetak(Request $request)
    {
        $user = auth()->user();

        // Delegate all query logic to LaporanExport
        $filters = array_filter([
            'kelurahan_id' => $request->kelurahan_id,
            'status'       => $request->status,
            'tgl_mulai'    => $request->tgl_mulai,
            'tgl_selesai'  => $request->tgl_selesai,
        ]);

        $filters['user_role'] = $user->role;
        $filters['user_kelurahan_id'] = $user->kelurahan_id;

        $fileName = 'Laporan_Prioritas_RTLH_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new LaporanExport($filters), $fileName);
    }
}
