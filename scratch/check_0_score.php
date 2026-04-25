<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$penilaian = App\Models\Penilaian::with(['penduduk', 'nilaiKriteria.kriteria', 'hasilSPK'])
    ->whereHas('hasilSPK', fn($q) => $q->where('nilai_defuzzifikasi', '<=', 0))
    ->first();

if ($penilaian) {
    echo "Nama: " . $penilaian->penduduk->nama_lengkap . "\n";
    foreach ($penilaian->nilaiKriteria as $nk) {
        echo $nk->kriteria->kode . ": " . $nk->nilai_input . " -> " . json_encode($nk->hasil_fuzzifikasi) . "\n";
    }
    echo "Skor: " . $penilaian->hasilSPK->nilai_defuzzifikasi . "\n";
} else {
    echo "No 0 scores found.\n";
}
