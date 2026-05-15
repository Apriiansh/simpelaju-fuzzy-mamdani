<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\FuzzyRule;
use App\Models\Kriteria;

$sets = [
    'K1' => ['Buruk', 'Sedang'],
    'K2' => ['Cukup', 'Sehat'],
    'K3' => ['Padat', 'Sedang'],
    'K4' => ['Sedang', 'Baik']
];

echo "Daftar Aturan (Rule) yang aktif untuk Siti Hayunah:\n";
echo str_repeat("-", 80) . "\n";
echo sprintf("%-8s | %-10s | %-10s | %-10s | %-10s | %-10s | %-5s\n", "No Rule", "K1", "K2", "K3", "K4", "Output", "Alpha");
echo str_repeat("-", 80) . "\n";

// Keanggotaan Siti (μ)
$mu = [
    'K1' => ['Buruk' => 0.085, 'Sedang' => 0.443],
    'K2' => ['Cukup' => 0.167, 'Sehat' => 0.500],
    'K3' => ['Padat' => 0.750, 'Sedang' => 0.222],
    'K4' => ['Sedang' => 0.667, 'Baik' => 0.625]
];

$rules = FuzzyRule::with('details.kriteria')->get();

foreach ($rules as $rule) {
    $match = true;
    $alpha = 1.0;
    $desc = [];
    
    foreach ($rule->details as $detail) {
        $kCode = $detail->kriteria->kode;
        $setName = $detail->fuzzy_set_nama;
        
        if (isset($sets[$kCode]) && in_array($setName, $sets[$kCode])) {
            $alpha = min($alpha, $mu[$kCode][$setName]);
            $desc[$kCode] = $setName;
        } else {
            $match = false;
            break;
        }
    }
    
    if ($match && $alpha > 0) {
        echo sprintf("%-8d | %-10s | %-10s | %-10s | %-10s | %-10s | %-5.3f\n", 
            $rule->nomor_rule, 
            $desc['K1'], $desc['K2'], $desc['K3'], $desc['K4'], 
            $rule->output_set, 
            $alpha
        );
    }
}
echo str_repeat("-", 80) . "\n";
