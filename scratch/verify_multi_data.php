<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\HasilSpk;

echo "\n--- HASIL SPK MAMDANI (MULTIPLE DATA) ---\n";
$results = HasilSpk::with('penilaian.penduduk')->get();

foreach ($results as $h) {
    $nama = $h->penilaian->penduduk->nama_lengkap;
    $skor = number_format($h->nilai_defuzzifikasi, 2);
    $kategori = $h->kategori_kelayakan;
    
    echo "$nama | Skor: $skor | Kategori: $kategori\n";
}
echo "----------------------------------------\n";
