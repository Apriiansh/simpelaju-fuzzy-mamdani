<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Plaju Darat', 'kode' => '1671071001'],
            ['nama' => 'Plaju Ilir', 'kode' => '1671071002'],
            ['nama' => 'Plaju Ulu', 'kode' => '1671071003'],
            ['nama' => 'Komperta', 'kode' => '1671071004'],
            ['nama' => 'Bagus Kuning', 'kode' => '1671071005'],
            ['nama' => 'Talang Bubuk', 'kode' => '1671071006'],
            ['nama' => 'Talang Putri', 'kode' => '1671071007'],
        ];

        foreach ($data as $item) {
            \App\Models\Kelurahan::updateOrCreate(['kode' => $item['kode']], $item);
        }
    }
}
