<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuzzyRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = [
            [
                'nomor' => 1,
                'output' => 'Layak',
                'conditions' => [
                    'ATAP' => 'Buruk',
                    'DINDING' => 'Buruk',
                    'LANTAI' => 'Buruk',
                    'PENGHASILAN' => 'Rendah'
                ]
            ],
            [
                'nomor' => 2,
                'output' => 'Layak',
                'conditions' => [
                    'ATAP' => 'Sedang',
                    'DINDING' => 'Buruk',
                    'LANTAI' => 'Buruk',
                    'PENGHASILAN' => 'Rendah'
                ]
            ],
            [
                'nomor' => 3,
                'output' => 'Tidak Layak',
                'conditions' => [
                    'ATAP' => 'Baik',
                    'DINDING' => 'Baik',
                    'LANTAI' => 'Baik',
                    'PENGHASILAN' => 'Tinggi'
                ]
            ],
            [
                'nomor' => 4,
                'output' => 'Tidak Layak',
                'conditions' => [
                    'ATAP' => 'Sedang',
                    'DINDING' => 'Sedang',
                    'LANTAI' => 'Sedang',
                    'LUAS' => 'Luas'
                ]
            ],
        ];

        foreach ($rules as $r) {
            $rule = \App\Models\FuzzyRule::updateOrCreate(
                ['nomor_rule' => $r['nomor']],
                ['operator' => 'AND', 'output_set' => $r['output']]
            );

            foreach ($r['conditions'] as $kCode => $setName) {
                $kriteria = \App\Models\Kriteria::where('kode', $kCode)->first();
                if ($kriteria) {
                    \App\Models\FuzzyRuleDetail::updateOrCreate(
                        ['fuzzy_rule_id' => $rule->id, 'kriteria_id' => $kriteria->id],
                        ['fuzzy_set_nama' => $setName]
                    );
                }
            }
        }
    }
}
