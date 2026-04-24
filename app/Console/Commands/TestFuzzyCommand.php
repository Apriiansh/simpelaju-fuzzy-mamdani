<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Penduduk;
use App\Models\Rumah;
use App\Models\Penilaian;
use App\Models\Kriteria;
use App\Models\NilaiKriteria;
use App\Services\Fuzzy\InputMapperService;
use App\Services\Fuzzy\MamdaniEngine;
use App\Models\Kelurahan;
use App\Models\User;

class TestFuzzyCommand extends Command
{
    protected $signature = 'app:test-fuzzy';
    protected $description = 'Run a step-by-step Fuzzy Mamdani test for a sample resident';

    public function handle(InputMapperService $mapper, MamdaniEngine $engine)
    {
        $this->info("=== 🧪 MEMULAI UJI VALIDASI FUZZY MAMDANI ===");

        // 1. Pastikan ada Data Master (Kelurahan & User)
        $kelurahan = Kelurahan::firstOrCreate(['nama' => 'PLAJU ULU', 'kode' => 'PLJ-001']);
        $user = User::firstOrCreate(
            ['email' => 'admin@simpelaju.com'],
            ['name' => 'Admin Tester', 'password' => bcrypt('password')]
        );

        // 2. Buat Data Dummy Penduduk & Rumah (Kondisi Buruk / Layak Dibantu)
        $this->warn("1. Menyiapkan Data Penduduk & Rumah (Kondisi: Buruk)...");
        $penduduk = Penduduk::updateOrCreate(
            ['nik' => '1234567890123456'],
            [
                'nama_lengkap' => 'Bapak Test Buruk',
                'alamat' => 'Jl. Uji Coba No. 1',
                'kelurahan_id' => $kelurahan->id,
                'jumlah_tanggungan' => 5,
                'penghasilan' => 1000000
            ]
        );

        $rumah = Rumah::updateOrCreate(
            ['penduduk_id' => $penduduk->id],
            [
                'pondasi' => 'Tidak Ada',
                'kolom_balok' => 'Rusak Berat',
                'konstruksi_atap' => 'Rusak Berat',
                'jendela' => 'Tidak Ada',
                'ventilasi' => 'Tidak Ada',
                'kamar_mandi' => 'Tidak Ada',
                'jarak_sumber_air' => 'Kurang dari 10 meter',
                'luas_bangunan' => 20, // 20 / 6 orang = 3.3 m2 (Sangat Padat)
                'kondisi_atap' => 'Rusak Berat / Seluruhnya',
                'kondisi_dinding' => 'Rusak Berat / Seluruhnya',
                'kondisi_lantai' => 'Rusak Berat / Seluruhnya',
            ]
        );

        // 3. Mapping Kualitatif -> Numerik
        $this->warn("2. Menjalankan Input Mapper (Konversi Teks -> Skor)...");
        $scores = $mapper->mapToScores($rumah);
        
        $penilaian = Penilaian::create([
            'penduduk_id' => $penduduk->id,
            'user_id' => $user->id,
            'periode' => 'TEST-VALIDASI',
            'status' => 'DIPROSES'
        ]);

        foreach ($scores as $kodeKriteria => $nilaiInput) {
            $kriteria = Kriteria::where('kode', $kodeKriteria)->first();
            if ($kriteria) {
                NilaiKriteria::create([
                    'penilaian_id' => $penilaian->id,
                    'kriteria_id' => $kriteria->id,
                    'nilai_input' => $nilaiInput
                ]);
                $this->line("   - {$kriteria->nama}: {$nilaiInput}");
            }
        }

        // 4. Jalankan Fuzzy Engine
        $this->warn("3. Menjalankan Mamdani Engine (Fuzzifikasi -> Inferensi -> Defuzzifikasi)...");
        $hasil = $engine->calculate($penilaian);

        // 5. Tampilkan Hasil
        $this->info("=== ✅ HASIL PERHITUNGAN ===");
        $this->table(
            ['Metrik', 'Nilai'],
            [
                ['Skor Defuzzifikasi (Z*)', $hasil->nilai_defuzzifikasi],
                ['Kategori Kelayakan', $hasil->kategori_kelayakan],
                ['Rekomendasi', $hasil->rekomendasi],
            ]
        );

        $this->warn("Detail Perhitungan (Fuzzifikasi):");
        $this->comment(json_encode($hasil->detail_perhitungan['fuzzification'], JSON_PRETTY_PRINT));
        
        $this->warn("Detail Perhitungan (Inference):");
        $this->comment(json_encode($hasil->detail_perhitungan['inference'], JSON_PRETTY_PRINT));

        $this->info("===========================================");
    }
}
