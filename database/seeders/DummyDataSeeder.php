<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penduduk;
use App\Models\Rumah;
use App\Services\Fuzzy\InputMapperService;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $mapper = app(InputMapperService::class);

        // 1. Siti Hayunah (Skenario Layak - Mirip PDF)
        $siti = Penduduk::create([
            'nik' => '1671000000000002',
            'nama_lengkap' => 'Siti Hayunah',
            'alamat' => 'Plaju Darat No. 12',
            'kelurahan_id' => 1,
            'no_telepon' => '081234567890',
            'status_pernikahan' => 'Kawin',
            'jumlah_tanggungan' => 5,
            'penghasilan' => 1500000,
        ]);

        Rumah::create([
            'penduduk_id' => $siti->id,
            'pondasi' => 'Ada',
            'kolom_balok' => 'Rusak Berat / Seluruhnya',
            'konstruksi_atap' => 'Rusak Berat / Seluruhnya',
            'jendela' => 'Ada',
            'ventilasi' => 'Ada',
            'kamar_mandi' => 'Sendiri',
            'jarak_sumber_air' => 'Kurang dari 10 meter',
            'luas_bangunan' => 30.00,
            'material_atap' => 'Genteng',
            'kondisi_atap' => 'Rusak Sedang / Sebagian',
            'material_dinding' => 'Bata Tanpa Plester',
            'kondisi_dinding' => 'Rusak Sedang / Sebagian',
            'material_lantai' => 'Plesteran',
            'kondisi_lantai' => 'Rusak Sedang / Sebagian',
        ]);
        $mapper->runAssessment($siti->id, '2026');

        // 2. Budi Santoso (Skenario Tidak Layak - Rumah Bagus)
        $budi = Penduduk::create([
            'nik' => '1671000000000003',
            'nama_lengkap' => 'Budi Santoso',
            'alamat' => 'Komperta Blok A1',
            'kelurahan_id' => 4,
            'no_telepon' => '081122334455',
            'status_pernikahan' => 'Kawin',
            'jumlah_tanggungan' => 3,
            'penghasilan' => 8500000,
        ]);

        Rumah::create([
            'penduduk_id' => $budi->id,
            'pondasi' => 'Ada',
            'kolom_balok' => 'Baik',
            'konstruksi_atap' => 'Baik',
            'jendela' => 'Ada',
            'ventilasi' => 'Ada',
            'kamar_mandi' => 'Sendiri',
            'jarak_sumber_air' => 'Lebih dari 10 meter',
            'luas_bangunan' => 100.00,
            'material_atap' => 'Genteng Beton / Keramik',
            'kondisi_atap' => 'Baik',
            'material_dinding' => 'Bata Diplester / Tembok Permanen',
            'kondisi_dinding' => 'Baik',
            'material_lantai' => 'Keramik',
            'kondisi_lantai' => 'Baik',
        ]);
        $mapper->runAssessment($budi->id, '2026');

        // 3. Agus Pratama (Skenario Sedang/Abu-abu)
        $agus = Penduduk::create([
            'nik' => '1671000000000004',
            'nama_lengkap' => 'Agus Pratama',
            'alamat' => 'Talang Bubuk No. 5',
            'kelurahan_id' => 6,
            'no_telepon' => '085566778899',
            'status_pernikahan' => 'Kawin',
            'jumlah_tanggungan' => 4,
            'penghasilan' => 3000000,
        ]);

        Rumah::create([
            'penduduk_id' => $agus->id,
            'pondasi' => 'Ada',
            'kolom_balok' => 'Rusak Sedang / Sebagian',
            'konstruksi_atap' => 'Rusak Sedang / Sebagian',
            'jendela' => 'Ada',
            'ventilasi' => 'Tidak Ada',
            'kamar_mandi' => 'Bersama/Umum',
            'jarak_sumber_air' => 'Kurang dari 10 meter',
            'luas_bangunan' => 45.00,
            'material_atap' => 'Seng',
            'kondisi_atap' => 'Rusak Sedang / Sebagian',
            'material_dinding' => 'Kayu / Papan',
            'kondisi_dinding' => 'Rusak Sedang / Sebagian',
            'material_lantai' => 'Kayu / Papan',
            'kondisi_lantai' => 'Baik',
        ]);
        $mapper->runAssessment($agus->id, '2026');
    }
}
