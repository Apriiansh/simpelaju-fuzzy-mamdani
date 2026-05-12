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
        Route::get('penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
        Route::post('penduduk', [PendudukController::class, 'store'])->name('penduduk.store');
        Route::get('penduduk/{penduduk}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit');
        Route::put('penduduk/{penduduk}', [PendudukController::class, 'update'])->name('penduduk.update');
        Route::delete('penduduk/{penduduk}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');

        Route::resource('rumah', RumahController::class);
        Route::post('rumah/{rumah}/recalculate', [RumahController::class, 'recalculate'])->name('rumah.recalculate');
        Route::post('penilaian/hitung-massal', [PenilaianController::class, 'hitungMassal'])->name('penilaian.hitung-massal');
        Route::post('penilaian/{penilaian}/kirim', [PenilaianController::class, 'kirimData'])->name('penilaian.kirim');
    });

    // Penilaian & Penduduk - Akses Campuran
    Route::get('penduduk', [PendudukController::class, 'index'])->name('penduduk.index');
    Route::get('penduduk/{penduduk}', [PendudukController::class, 'show'])->name('penduduk.show');

    Route::get('penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('penilaian/{penilaian}', [PenilaianController::class, 'show'])->name('penilaian.show');
    
    Route::middleware('role:operator')->group(function() {
        Route::get('penilaian/create', [PenilaianController::class, 'create'])->name('penilaian.create');
        Route::post('penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
        Route::get('penilaian/{penilaian}/edit', [PenilaianController::class, 'edit'])->name('penilaian.edit');
        Route::put('penilaian/{penilaian}', [PenilaianController::class, 'update'])->name('penilaian.update');
        Route::delete('penilaian/{penilaian}', [PenilaianController::class, 'destroy'])->name('penilaian.destroy');
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
