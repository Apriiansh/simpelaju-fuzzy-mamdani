<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Penilaian;
use App\Models\HasilSpk;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $pendudukQuery = Penduduk::query();
        $penilaianQuery = Penilaian::query();
        $hasilSpkQuery = HasilSpk::query();

        // Jika Operator (Lurah), filter hanya kelurahannya
        if ($user->role === 'operator') {
            $pendudukQuery->where('kelurahan_id', $user->kelurahan_id);
            $penilaianQuery->whereHas('penduduk', function($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            });
            $hasilSpkQuery->whereHas('penilaian.penduduk', function($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            });
        }

        $stats = [
            'total_penduduk' => $pendudukQuery->count(),
            'total_dinilai' => $penilaianQuery->clone()->where('verifikasi_status', '!=', 'draft')->count(),
            'total_layak' => $hasilSpkQuery->clone()->where('kategori_kelayakan', 'LAYAK')->count(),
            'total_tidak_layak' => $hasilSpkQuery->clone()->where('kategori_kelayakan', 'TIDAK_LAYAK')->count(),
            'total_belum_verifikasi' => $penilaianQuery->clone()->where('verifikasi_status', 'dikirim')->count(),
        ];

        // Fetch top 5 candidates by defuzzification score
        $rankingsQuery = HasilSpk::with('penilaian.penduduk')
            ->orderBy('nilai_defuzzifikasi', 'desc');

        if ($user->role === 'operator') {
            $rankingsQuery->whereHas('penilaian.penduduk', function($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            });
        }

        $rankings = $rankingsQuery->limit(5)->get();

        return view('dashboard', array_merge($stats, [
            'rankings' => $rankings,
            'user_role' => $user->role,
            'kelurahan' => $user->kelurahan?->nama_kelurahan ?? 'Kecamatan Plaju'
        ]));
    }
}
