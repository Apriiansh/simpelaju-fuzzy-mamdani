<?php
require dirname(__DIR__) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__) . '/bootstrap/app.php';

use App\Models\Penduduk;
use App\Services\Fuzzy\InputMapperService;
use Illuminate\Support\Facades\Log;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $p = Penduduk::has('rumah')->first();
    if (!$p) {
        echo "ERROR: Tidak ada penduduk yang punya data rumah.\n";
        exit;
    }

    echo "Testing for: " . $p->nama_lengkap . " (ID: " . $p->id . ")\n";
    
    $service = app(InputMapperService::class);
    
    echo "1. Mapping Scores...\n";
    $scores = $service->mapToScores($p->rumah);
    print_r($scores);

    echo "2. Running Full Assessment...\n";
    $res = $service->runAssessment($p->id, date('Y'));
    
    if ($res && $res->hasilSPK) {
        echo "SUCCESS!\n";
        echo "Kategori: " . $res->hasilSPK->kategori_kelayakan . "\n";
        echo "Skor: " . $res->hasilSPK->nilai_defuzzifikasi . "\n";
    } else {
        echo "FAILED: Hasil SPK tetap kosong.\n";
    }

} catch (\Exception $e) {
    echo "CRITICAL ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
