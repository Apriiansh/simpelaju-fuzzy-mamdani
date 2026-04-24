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
                // Kepadatan (Pilar C) - Based on Screenshot 3
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Padat', 'tipe' => 'trapesium', 'parameter' => [0, 0, 5, 9]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Sedang', 'tipe' => 'segitiga', 'parameter' => [5, 9.5, 14]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Layak', 'tipe' => 'trapesium', 'parameter' => [10, 14, 30, 30]]);
            } elseif ($k['kode'] === 'K2') {
                // Kesehatan (Pilar B) - Label: Tidak Sehat, Cukup, Sehat
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Tidak Sehat', 'tipe' => 'trapesium', 'parameter' => [0, 0, 0.15, 0.35]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Cukup', 'tipe' => 'segitiga', 'parameter' => [0.2, 0.5, 0.8]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Sehat', 'tipe' => 'trapesium', 'parameter' => [0.65, 0.85, 1, 1]]);
            } else {
                // Aspek A, D - Label: Buruk, Sedang, Baik
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Buruk', 'tipe' => 'trapesium', 'parameter' => [0, 0, 0.15, 0.35]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Sedang', 'tipe' => 'segitiga', 'parameter' => [0.2, 0.5, 0.8]]);
                FuzzySet::create(['kriteria_id' => $kriteria->id, 'nama' => 'Baik', 'tipe' => 'trapesium', 'parameter' => [0.65, 0.85, 1, 1]]);
            }
        }

        // 2.5 Setup Output Sets (kriteria_id = null)
        FuzzySet::create(['nama' => 'TIDAK LAYAK', 'tipe' => 'trapesium', 'parameter' => [0, 0, 30, 50]]);
        FuzzySet::create(['nama' => 'LAYAK', 'tipe' => 'trapesium', 'parameter' => [50, 70, 100, 100]]);

        // 3. Setup Rules (Mamdani - Tabel 3.9)
        $rules = [
            // Format: [A, B, C, D, Output]
            ['Buruk', 'Tidak Sehat', 'Padat', 'Buruk', 'LAYAK'], // R1
            ['Buruk', 'Tidak Sehat', 'Padat', 'Sedang', 'LAYAK'], // R2
            ['Buruk', 'Tidak Sehat', 'Sedang', 'Buruk', 'LAYAK'], // R3
            ['Buruk', 'Cukup', 'Padat', 'Buruk', 'LAYAK'], // R4
            ['Sedang', 'Tidak Sehat', 'Padat', 'Buruk', 'LAYAK'], // R5
            ['Buruk', 'Tidak Sehat', 'Padat', 'Baik', 'LAYAK'], // R6
            ['Buruk', 'Tidak Sehat', 'Sedang', 'Sedang', 'LAYAK'], // R7
            ['Buruk', 'Cukup', 'Padat', 'Sedang', 'LAYAK'], // R8
            ['Sedang', 'Tidak Sehat', 'Padat', 'Sedang', 'LAYAK'], // R9
            ['Buruk', 'Cukup', 'Sedang', 'Buruk', 'LAYAK'], // R10
            ['Sedang', 'Cukup', 'Padat', 'Buruk', 'LAYAK'], // R11
            ['Sedang', 'Tidak Sehat', 'Sedang', 'Buruk', 'LAYAK'], // R12
            ['Buruk', 'Tidak Sehat', 'Layak', 'Buruk', 'LAYAK'], // R13
            ['Buruk', 'Sehat', 'Padat', 'Buruk', 'LAYAK'], // R14
            ['Buruk', 'Cukup', 'Sedang', 'Sedang', 'LAYAK'], // R15
            ['Sedang', 'Cukup', 'Sedang', 'Sedang', 'LAYAK'], // R16
            ['Sedang', 'Cukup', 'Padat', 'Sedang', 'LAYAK'], // R17
            ['Buruk', 'Cukup', 'Padat', 'Baik', 'LAYAK'], // R18
            ['Sedang', 'Tidak Sehat', 'Sedang', 'Sedang', 'LAYAK'], // R19
            ['Sedang', 'Cukup', 'Sedang', 'Buruk', 'LAYAK'], // R20
            ['Buruk', 'Sehat', 'Sedang', 'Sedang', 'LAYAK'], // R21
            ['Sedang', 'Sehat', 'Sedang', 'Sedang', 'LAYAK'], // R22
            ['Baik', 'Sehat', 'Layak', 'Baik', 'TIDAK LAYAK'], // R23
            ['Baik', 'Sehat', 'Layak', 'Sedang', 'TIDAK LAYAK'], // R24
            ['Baik', 'Sehat', 'Sedang', 'Baik', 'TIDAK LAYAK'], // R25
            ['Baik', 'Cukup', 'Layak', 'Baik', 'TIDAK LAYAK'], // R26
            ['Sedang', 'Sehat', 'Layak', 'Baik', 'TIDAK LAYAK'], // R27
            ['Baik', 'Sehat', 'Layak', 'Buruk', 'LAYAK'], // R28
            ['Baik', 'Cukup', 'Layak', 'Sedang', 'TIDAK LAYAK'], // R29
            ['Sedang', 'Sehat', 'Layak', 'Sedang', 'TIDAK LAYAK'], // R30
            ['Baik', 'Sehat', 'Sedang', 'Sedang', 'TIDAK LAYAK'], // R31
            ['Baik', 'Cukup', 'Sedang', 'Baik', 'TIDAK LAYAK'], // R32
            ['Sedang', 'Sehat', 'Sedang', 'Baik', 'TIDAK LAYAK'], // R33
            ['Baik', 'Tidak Sehat', 'Layak', 'Baik', 'TIDAK LAYAK'], // R34
            ['Sedang', 'Cukup', 'Layak', 'Baik', 'TIDAK LAYAK'], // R35
            ['Baik', 'Sehat', 'Padat', 'Baik', 'LAYAK'], // R36
            ['Baik', 'Sehat', 'Layak', 'Buruk', 'LAYAK'], // R37 (Double in PDF, keeping it)
        ];

        foreach ($rules as $index => $r) {
            $rule = FuzzyRule::create([
                'nomor_rule' => $index + 1,
                'output_set' => $r[4],
                'operator' => 'AND'
            ]);

            $k1 = Kriteria::where('kode', 'K1')->first();
            $k2 = Kriteria::where('kode', 'K2')->first();
            $k3 = Kriteria::where('kode', 'K3')->first();
            $k4 = Kriteria::where('kode', 'K4')->first();

            FuzzyRuleDetail::create(['fuzzy_rule_id' => $rule->id, 'kriteria_id' => $k1->id, 'fuzzy_set_nama' => $r[0]]);
            FuzzyRuleDetail::create(['fuzzy_rule_id' => $rule->id, 'kriteria_id' => $k2->id, 'fuzzy_set_nama' => $r[1]]);
            FuzzyRuleDetail::create(['fuzzy_rule_id' => $rule->id, 'kriteria_id' => $k3->id, 'fuzzy_set_nama' => $r[2]]);
            FuzzyRuleDetail::create(['fuzzy_rule_id' => $rule->id, 'kriteria_id' => $k4->id, 'fuzzy_set_nama' => $r[3]]);
        }
    }
}
