<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penduduk;
use App\Models\Rumah;
use App\Services\Fuzzy\InputMapperService;
use Faker\Factory as Faker;

class MassResidentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $mapper = app(InputMapperService::class);

        // Opsi-opsi kriteria sesuai dengan form
        $pondasi_options = ['Ada', 'Tidak Ada'];
        $kolom_options = ['Baik', 'Rusak Sedang / Sebagian', 'Rusak Berat / Seluruhnya'];
        $atap_options = ['Baik', 'Rusak Sedang / Sebagian', 'Rusak Berat / Seluruhnya'];
        $jendela_options = ['Ada', 'Tidak Ada'];
        $ventilasi_options = ['Ada', 'Tidak Ada'];
        $mck_options = ['Sendiri', 'Bersama / MCK Komunal', 'Tidak Ada'];
        $jarak_air_options = ['Lebih dari 10 meter', 'Kurang dari 10 meter'];
        
        $mat_atap_options = ['Genteng Beton / Keramik', 'Genteng Tanah Liat', 'Seng', 'Asbes', 'Daun / Rumbia / Ijuk'];
        $mat_dinding_options = ['Bata Diplester / Tembok Permanen', 'Bata Tanpa Plester', 'Semi Permanen (Triplek, dll)', 'Kayu Papan', 'Bambu / Anyaman'];
        $mat_lantai_options = ['Granit / Ubin Berkualitas', 'Keramik', 'Plester Semen', 'Bambu / Kayu Kasar', 'Tanah'];
        $kondisi_options = ['Baik', 'Rusak Sedang / Sebagian', 'Rusak Berat / Seluruhnya'];

        // Koordinat wilayah Plaju (sekitar Latitude: -3.00, Longitude: 104.82)
        $lat_min = -3.015000;
        $lat_max = -2.985000;
        $lng_min = 104.805000;
        $lng_max = 104.845000;

        echo "Seeding 30 random residents with fuzzy assessment...\n";

        for ($i = 0; $i < 30; $i++) {
            $penduduk = Penduduk::create([
                'nik' => $faker->unique()->numerify('167100##########'),
                'nama_lengkap' => $faker->name,
                'alamat' => $faker->streetAddress,
                'kelurahan_id' => $faker->numberBetween(1, 7), // 7 kelurahan di Plaju
                'no_telepon' => $faker->phoneNumber,
                'status_pernikahan' => $faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']),
                'jumlah_tanggungan' => $faker->numberBetween(1, 7),
                'penghasilan' => $faker->numberBetween(800000, 6000000),
                'latitude' => $faker->randomFloat(6, $lat_min, $lat_max),
                'longitude' => $faker->randomFloat(6, $lng_min, $lng_max),
            ]);

            Rumah::create([
                'penduduk_id' => $penduduk->id,
                'status_kepemilikan' => $faker->randomElement(['Milik Sendiri', 'Sewa', 'Numpang', 'Lainnya']),
                'pondasi' => $faker->randomElement($pondasi_options),
                'kolom_balok' => $faker->randomElement($kolom_options),
                'konstruksi_atap' => $faker->randomElement($atap_options),
                'jendela' => $faker->randomElement($jendela_options),
                'ventilasi' => $faker->randomElement($ventilasi_options),
                'kamar_mandi' => $faker->randomElement($mck_options),
                'jarak_sumber_air' => $faker->randomElement($jarak_air_options),
                'luas_bangunan' => $faker->randomFloat(2, 15, 120),
                'material_atap' => $faker->randomElement($mat_atap_options),
                'kondisi_atap' => $faker->randomElement($kondisi_options),
                'material_dinding' => $faker->randomElement($mat_dinding_options),
                'kondisi_dinding' => $faker->randomElement($kondisi_options),
                'material_lantai' => $faker->randomElement($mat_lantai_options),
                'kondisi_lantai' => $faker->randomElement($kondisi_options),
            ]);

            // Jalankan fuzzy otomatis
            $mapper->runAssessment($penduduk->id, '2026');
        }

        echo "Berhasil membuat 30 data penduduk beserta rumah & hasil fuzzy!\n";
    }
}
