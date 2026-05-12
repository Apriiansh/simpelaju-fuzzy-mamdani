<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\RumahController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil (Semua Role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk Operator Lurah
    Route::middleware('role:operator')->group(function () {
        Route::resource('penduduk', PendudukController::class);
        Route::resource('rumah', RumahController::class);
        Route::post('rumah/{rumah}/recalculate', [RumahController::class, 'recalculate'])->name('rumah.recalculate');
        Route::resource('penilaian', PenilaianController::class);
        Route::post('penilaian/hitung-massal', [PenilaianController::class, 'hitungMassal'])->name('penilaian.hitung-massal');
        Route::post('penilaian/{penilaian}/kirim', [PenilaianController::class, 'kirimData'])->name('penilaian.kirim');
    });

    // Route untuk Admin Camat
    Route::middleware('role:admin')->group(function () {
        Route::resource('kelurahan', KelurahanController::class);
        Route::resource('users', UserController::class);
        Route::get('kriteria-fuzzy', [\App\Http\Controllers\KriteriaFuzzyController::class, 'index'])->name('kriteria-fuzzy.index');
        Route::post('penilaian/{penilaian}/verifikasi', [PenilaianController::class, 'verifikasi'])->name('penilaian.verifikasi');
    });

    // Route untuk Camat (Pimpinan)
    Route::middleware('role:camat')->group(function () {
        Route::post('penilaian/{penilaian}/validasi', [PenilaianController::class, 'validasi'])->name('penilaian.validasi');
    });

    // Route Bersama Admin & Camat
    Route::middleware('role:admin,camat')->group(function () {
        Route::get('web-gis', [\App\Http\Controllers\WebGisController::class, 'index'])->name('web-gis.index');
        Route::get('laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/cetak', [\App\Http\Controllers\LaporanController::class, 'cetak'])->name('laporan.cetak');
    });
});

require __DIR__.'/auth.php';
