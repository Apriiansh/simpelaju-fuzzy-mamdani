<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class WebGisController extends Controller
{
    public function index()
    {
        // Get all residents with valid coordinates
        $penduduk = Penduduk::with(['kelurahan', 'penilaian.hasilSPK', 'rumah'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // Transform data into a clean array for Javascript (Leaflet)
        $geoData = $penduduk->map(function ($p) {
            $latestPenilaian = $p->penilaian->last();
            $hasil = $latestPenilaian ? $latestPenilaian->hasilSPK : null;
            
            $status = 'BELUM DINILAI';
            $score = 0;
            if ($hasil) {
                // Ensure consistency in naming
                $status = $hasil->kategori_kelayakan === 'TIDAK_LAYAK' ? 'TIDAK LAYAK' : $hasil->kategori_kelayakan;
                $score = $hasil->nilai_defuzzifikasi;
            }

            return [
                'id' => $p->id,
                'nama' => $p->nama_lengkap,
                'nik' => $p->nik,
                'kelurahan' => $p->kelurahan->nama ?? '-',
                'lat' => $p->latitude,
                'lng' => $p->longitude,
                'status' => $status,
                'score' => number_format($score, 2),
                'url' => route('penduduk.show', $p->id)
            ];
        });

        // Calculate statistics for the right panel
        $stats = [
            'total' => $penduduk->count(),
            'layak' => $geoData->where('status', 'LAYAK')->count(),
            'tidak_layak' => $geoData->where('status', 'TIDAK LAYAK')->count(),
            'belum_dinilai' => $geoData->where('status', 'BELUM DINILAI')->count(),
        ];

        return view('web-gis.index', compact('geoData', 'stats'));
    }
}
