<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== KRITERIA & FUZZY SETS ===\n";
$kriterias = App\Models\Kriteria::with('fuzzySets')->orderBy('kode')->get();
foreach ($kriterias as $k) {
    echo "\n[{$k->kode}] {$k->nama} (bobot: {$k->bobot})\n";
    foreach ($k->fuzzySets as $fs) {
        echo "  -> {$fs->nama} [{$fs->tipe}] params: " . json_encode($fs->parameter) . "\n";
    }
}

echo "\n\n=== OUTPUT FUZZY SETS (Defuzzifikasi) ===\n";
$outputSets = App\Models\FuzzySet::whereNull('kriteria_id')->get();
foreach ($outputSets as $fs) {
    echo "  -> {$fs->nama} [{$fs->tipe}] params: " . json_encode($fs->parameter) . "\n";
}

echo "\n\n=== FUZZY RULES (". App\Models\FuzzyRule::where('is_active',true)->count() ." rules active) ===\n";
$rules = App\Models\FuzzyRule::with('details.kriteria')->where('is_active', true)->orderBy('id')->get();
foreach ($rules as $i => $r) {
    $conditions = $r->details->map(fn($d) => "{$d->kriteria->kode}={$d->fuzzy_set_nama}")->join(' AND ');
    echo "R".($i+1)." | IF {$conditions} THEN {$r->output_set}\n";
}
