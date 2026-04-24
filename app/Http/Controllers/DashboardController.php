<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Penilaian;
use App\Models\HasilSpk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_penduduk' => Penduduk::count(),
            'total_dinilai' => Penilaian::count(),
            'total_layak' => HasilSpk::where('kategori_kelayakan', 'LAYAK')->count(),
            'total_tidak_layak' => HasilSpk::where('kategori_kelayakan', 'TIDAK_LAYAK')->count(),
        ];

        // Fetch top 5 candidates by defuzzification score
        $rankings = HasilSpk::with('penilaian.penduduk')
            ->orderBy('nilai_defuzzifikasi', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', array_merge($stats, ['rankings' => $rankings]));
    }
}
