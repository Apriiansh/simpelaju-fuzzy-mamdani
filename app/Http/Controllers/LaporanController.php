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
        $kelurahans = Kelurahan::all();

        $query = HasilSpk::with(['penilaian.penduduk.kelurahan', 'penilaian.penduduk.rumah'])
            ->join('penilaian', 'hasil_spk.penilaian_id', '=', 'penilaian.id')
            ->join('penduduk', 'penilaian.penduduk_id', '=', 'penduduk.id')
            ->select('hasil_spk.*', 'penduduk.nama_lengkap', 'penduduk.nik', 'penilaian.verifikasi_status')
            ->where('penilaian.verifikasi_status', 'valid'); // Hanya yang sudah disahkan Camat

        if ($request->filled('kelurahan_id')) {
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
        // Delegate all query logic to LaporanExport
        $filters = array_filter([
            'kelurahan_id' => $request->kelurahan_id,
            'status'       => $request->status,
            'tgl_mulai'    => $request->tgl_mulai,
            'tgl_selesai'  => $request->tgl_selesai,
        ]);

        $fileName = 'Laporan_Prioritas_RTLH_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new LaporanExport($filters), $fileName);
    }
}
