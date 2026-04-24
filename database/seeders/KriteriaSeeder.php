<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriteria = [
            [
                'nama' => 'Kondisi Atap',
                'kode' => 'ATAP',
                'min_value' => 0, 'max_value' => 100, 'satuan' => 'skor',
                'sets' => [
                    ['nama' => 'Buruk', 'tipe' => 'trapesium', 'parameter' => [0, 0, 25, 50]],
                    ['nama' => 'Sedang', 'tipe' => 'segitiga', 'parameter' => [25, 50, 75]],
                    ['nama' => 'Baik', 'tipe' => 'trapesium', 'parameter' => [50, 75, 100, 100]],
                ]
            ],
            [
                'nama' => 'Kondisi Dinding',
                'kode' => 'DINDING',
                'min_value' => 0, 'max_value' => 100, 'satuan' => 'skor',
                'sets' => [
                    ['nama' => 'Buruk', 'tipe' => 'trapesium', 'parameter' => [0, 0, 25, 50]],
                    ['nama' => 'Sedang', 'tipe' => 'segitiga', 'parameter' => [25, 50, 75]],
                    ['nama' => 'Baik', 'tipe' => 'trapesium', 'parameter' => [50, 75, 100, 100]],
                ]
            ],
            [
                'nama' => 'Kondisi Lantai',
                'kode' => 'LANTAI',
                'min_value' => 0, 'max_value' => 100, 'satuan' => 'skor',
                'sets' => [
                    ['nama' => 'Buruk', 'tipe' => 'trapesium', 'parameter' => [0, 0, 25, 50]],
                    ['nama' => 'Sedang', 'tipe' => 'segitiga', 'parameter' => [25, 50, 75]],
                    ['nama' => 'Baik', 'tipe' => 'trapesium', 'parameter' => [50, 75, 100, 100]],
                ]
            ],
            [
                'nama' => 'Luas Bangunan',
                'kode' => 'LUAS',
                'min_value' => 0, 'max_value' => 100, 'satuan' => 'm²',
                'sets' => [
                    ['nama' => 'Kecil', 'tipe' => 'trapesium', 'parameter' => [0, 0, 20, 40]],
                    ['nama' => 'Sedang', 'tipe' => 'segitiga', 'parameter' => [20, 45, 70]],
                    ['nama' => 'Luas', 'tipe' => 'trapesium', 'parameter' => [50, 70, 100, 100]],
                ]
            ],
            [
                'nama' => 'Penghasilan',
                'kode' => 'PENGHASILAN',
                'min_value' => 0, 'max_value' => 5000000, 'satuan' => 'Rp/bulan',
                'sets' => [
                    ['nama' => 'Rendah', 'tipe' => 'trapesium', 'parameter' => [0, 0, 1000000, 2000000]],
                    ['nama' => 'Sedang', 'tipe' => 'segitiga', 'parameter' => [1500000, 2500000, 3500000]],
                    ['nama' => 'Tinggi', 'tipe' => 'trapesium', 'parameter' => [3000000, 4000000, 5000000, 5000000]],
                ]
            ],
            [
                'nama' => 'Jumlah Tanggungan',
                'kode' => 'TANGGUNGAN',
                'min_value' => 0, 'max_value' => 10, 'satuan' => 'orang',
                'sets' => [
                    ['nama' => 'Sedikit', 'tipe' => 'trapesium', 'parameter' => [0, 0, 1, 3]],
                    ['nama' => 'Sedang', 'tipe' => 'segitiga', 'parameter' => [2, 4, 6]],
                    ['nama' => 'Banyak', 'tipe' => 'trapesium', 'parameter' => [5, 7, 10, 10]],
                ]
            ],
            [
                'nama' => 'Status Kepemilikan',
                'kode' => 'KEPEMILIKAN',
                'min_value' => 0, 'max_value' => 100, 'satuan' => 'skor',
                'sets' => [
                    ['nama' => 'Tidak Milik', 'tipe' => 'trapesium', 'parameter' => [0, 0, 20, 40]],
                    ['nama' => 'Sewa', 'tipe' => 'segitiga', 'parameter' => [30, 50, 70]],
                    ['nama' => 'Milik Sendiri', 'tipe' => 'trapesium', 'parameter' => [60, 80, 100, 100]],
                ]
            ],
            [
                'nama' => 'Kelayakan Bantuan',
                'kode' => 'KELAYAKAN',
                'min_value' => 0, 'max_value' => 100, 'satuan' => 'skor',
                'sets' => [
                    ['nama' => 'Tidak Layak', 'tipe' => 'trapesium', 'parameter' => [0, 0, 30, 50]],
                    ['nama' => 'Layak', 'tipe' => 'trapesium', 'parameter' => [50, 70, 100, 100]],
                ]
            ],
        ];

        foreach ($kriteria as $k) {
            $obj = \App\Models\Kriteria::updateOrCreate(
                ['kode' => $k['kode']],
                ['nama' => $k['nama'], 'min_value' => $k['min_value'], 'max_value' => $k['max_value'], 'satuan' => $k['satuan']]
            );

            foreach ($k['sets'] as $s) {
                \App\Models\FuzzySet::updateOrCreate(
                    ['kriteria_id' => $obj->id, 'nama' => $s['nama']],
                    ['tipe' => $s['tipe'], 'parameter' => $s['parameter']]
                );
            }
        }
    }
}
