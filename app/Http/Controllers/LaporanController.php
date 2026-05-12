<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelurahan;
use App\Models\HasilSpk;
use Barryvdh\DomPDF\Facade\Pdf;

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

        // Default order by score descending (Priority 1 is the highest score)
        $query->orderBy('hasil_spk.nilai_defuzzifikasi', 'desc');

        $laporan = $query->paginate(20)->withQueryString();

        return view('laporan.index', compact('laporan', 'kelurahans'));
    }

    public function cetak(Request $request)
    {
        $query = HasilSpk::with(['penilaian.penduduk.kelurahan', 'penilaian.penduduk.rumah'])
            ->join('penilaian', 'hasil_spk.penilaian_id', '=', 'penilaian.id')
            ->join('penduduk', 'penilaian.penduduk_id', '=', 'penduduk.id')
            ->select('hasil_spk.*', 'penduduk.nama_lengkap', 'penduduk.nik', 'penilaian.verifikasi_status')
            ->where('penilaian.verifikasi_status', 'valid'); // Hanya yang sudah disahkan Camat

        $filters = [];

        if ($request->filled('kelurahan_id')) {
            $query->where('penduduk.kelurahan_id', $request->kelurahan_id);
            $kelurahan = Kelurahan::find($request->kelurahan_id);
            $filters['kelurahan'] = $kelurahan ? $kelurahan->nama : 'Semua';
        }

        if ($request->filled('status')) {
            $query->where('hasil_spk.kategori_kelayakan', $request->status);
            $filters['status'] = str_replace('_', ' ', $request->status);
        }

        if ($request->filled('tgl_mulai')) {
            $query->whereDate('penilaian.tanggal_penilaian', '>=', $request->tgl_mulai);
            $filters['tgl_mulai'] = $request->tgl_mulai;
        }

        if ($request->filled('tgl_selesai')) {
            $query->whereDate('penilaian.tanggal_penilaian', '<=', $request->tgl_selesai);
            $filters['tgl_selesai'] = $request->tgl_selesai;
        }

        $query->orderBy('hasil_spk.nilai_defuzzifikasi', 'desc');
        // For PDF, we usually get all data without pagination, or set a high limit
        $laporan = $query->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('laporan', 'filters'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream('Laporan_Prioritas_Bantuan_RTLH.pdf');
    }
}
