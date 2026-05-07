<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use App\Models\FuzzySet;
use App\Models\FuzzyRule;
use App\Models\FuzzyRuleDetail;

class FuzzyConfigurationSeeder extends Seeder
{
    public function run()
    {
        // 0. Bersihkan data lama
        \Schema::disableForeignKeyConstraints();
        \DB::table('fuzzy_rule_details')->truncate();
        \DB::table('fuzzy_rules')->truncate();
        \DB::table('fuzzy_sets')->truncate();
        \DB::table('nilai_kriteria')->truncate();
        \DB::table('hasil_spk')->truncate();
        \DB::table('penilaian')->truncate();
        \DB::table('kriteria')->truncate();
        \Schema::enableForeignKeyConstraints();

        // 1. Setup Kriteria (4 Pilar)
        $kriterias = [
            ['kode' => 'K1', 'nama' => 'Aspek Keselamatan', 'min_value' => 0, 'max_value' => 1, 'satuan' => 'Indeks'],
            ['kode' => 'K2', 'nama' => 'Aspek Kesehatan', 'min_value' => 0, 'max_value' => 1, 'satuan' => 'Indeks'],
            ['kode' => 'K3', 'nama' => 'Aspek Kepadatan', 'min_value' => 0, 'max_value' => 30, 'satuan' => 'm2/org'],
            ['kode' => 'K4', 'nama' => 'Aspek Komponen', 'min_value' => 0, 'max_value' => 1, 'satuan' => 'Indeks'],
        ];

        foreach ($kriterias as $k) {
            $kriteria = Kriteria::create($k);

            if ($k['kode'] === 'K3') {
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Padat', 'tipe' => 'trapesium', 'parameter' => [0, 0, 5, 9]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Sedang', 'tipe' => 'segitiga', 'parameter' => [5, 9.5, 14]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Layak', 'tipe' => 'trapesium', 'parameter' => [10, 14, 30, 30]]);
            } elseif ($k['kode'] === 'K2') {
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Tidak Sehat', 'tipe' => 'trapesium', 'parameter' => [0, 0, 0.15, 0.35]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Cukup', 'tipe' => 'segitiga', 'parameter' => [0.2, 0.5, 0.8]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Sehat', 'tipe' => 'trapesium', 'parameter' => [0.65, 0.85, 1, 1]]);
            } else {
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Buruk', 'tipe' => 'trapesium', 'parameter' => [0, 0, 0.15, 0.35]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Sedang', 'tipe' => 'segitiga', 'parameter' => [0.2, 0.5, 0.8]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Baik', 'tipe' => 'trapesium', 'parameter' => [0.65, 0.85, 1, 1]]);
            }
        }

        // 2. Setup Output Sets
        FuzzySet::create(['nama' => 'TIDAK LAYAK', 'tipe' => 'trapesium', 'parameter' => [0, 0, 30, 50]]);
        FuzzySet::create(['nama' => 'LAYAK', 'tipe' => 'trapesium', 'parameter' => [50, 70, 100, 100]]);

        // 3. Setup Rules (Full 81 Rules - Cartesian Product 3^4)
        $setsK1 = ['Buruk', 'Sedang', 'Baik'];
        $setsK2 = ['Tidak Sehat', 'Cukup', 'Sehat'];
        $setsK3 = ['Padat', 'Sedang', 'Layak'];
        $setsK4 = ['Buruk', 'Sedang', 'Baik'];

        $rules = [];
        $index = 1;

        foreach ($setsK1 as $s1) {
            foreach ($setsK2 as $s2) {
                foreach ($setsK3 as $s3) {
                    foreach ($setsK4 as $s4) {
                        // Logika Penentuan Output Berdasarkan Bobot (Heuristik)
                        // Buruk/Tidak Sehat/Padat = 2 poin
                        // Sedang/Cukup = 1 poin
                        // Baik/Sehat/Layak = 0 poin
                        
                        $score = 0;
                        $score += ($s1 === 'Buruk' ? 2 : ($s1 === 'Sedang' ? 1 : 0));
                        $score += ($s2 === 'Tidak Sehat' ? 2 : ($s2 === 'Cukup' ? 1 : 0));
                        $score += ($s3 === 'Padat' ? 2 : ($s3 === 'Sedang' ? 1 : 0));
                        $score += ($s4 === 'Buruk' ? 2 : ($s4 === 'Sedang' ? 1 : 0));

                        // Jika total skor >= 4 (minimal 2 kondisi buruk atau 4 kondisi sedang), maka LAYAK
                        // Threshold ini bisa disesuaikan. 4 dari 8 poin maksimal adalah titik tengah.
                        $output = ($score >= 4) ? 'LAYAK' : 'TIDAK LAYAK';

                        $rules[] = [$s1, $s2, $s3, $s4, $output];
                    }
                }
            }
        }

        $k1 = Kriteria::where('kode', 'K1')->first();
        $k2 = Kriteria::where('kode', 'K2')->first();
        $k3 = Kriteria::where('kode', 'K3')->first();
        $k4 = Kriteria::where('kode', 'K4')->first();

        foreach ($rules as $i => $r) {
            $rule = FuzzyRule::create([
                'nomor_rule' => $i + 1,
                'output_set' => $r[4],
                'operator' => 'AND'
            ]);

            FuzzyRuleDetail::create(['fuzzy_rule_id' => $rule->id, 'kriteria_id' => $k1->id, 'fuzzy_set_nama' => $r[0]]);
            FuzzyRuleDetail::create(['fuzzy_rule_id' => $rule->id, 'kriteria_id' => $k2->id, 'fuzzy_set_nama' => $r[1]]);
            FuzzyRuleDetail::create(['fuzzy_rule_id' => $rule->id, 'kriteria_id' => $k3->id, 'fuzzy_set_nama' => $r[2]]);
            FuzzyRuleDetail::create(['fuzzy_rule_id' => $rule->id, 'kriteria_id' => $k4->id, 'fuzzy_set_nama' => $r[3]]);
        }
    }
}
