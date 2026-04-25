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
            ->select('hasil_spk.*', 'penduduk.nama_lengkap', 'penduduk.nik');

        if ($request->filled('kelurahan_id')) {
            $query->where('penduduk.kelurahan_id', $request->kelurahan_id);
        }

        if ($request->filled('status')) {
            $query->where('hasil_spk.kategori_kelayakan', $request->status);
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
            ->select('hasil_spk.*', 'penduduk.nama_lengkap', 'penduduk.nik');

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

        $query->orderBy('hasil_spk.nilai_defuzzifikasi', 'desc');
        // For PDF, we usually get all data without pagination, or set a high limit
        $laporan = $query->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('laporan', 'filters'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream('Laporan_Prioritas_Bantuan_RTLH.pdf');
    }
}
