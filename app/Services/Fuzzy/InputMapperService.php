<?php

namespace App\Services\Fuzzy;

use App\Models\Rumah;
use App\Models\Kriteria;
use App\Models\NilaiKriteria;
use App\Models\Penilaian;

class InputMapperService
{
    /**
     * Map qualitative values from Rumah model to numeric scores (0.0 - 1.0).
     * 1.0 = Good/Healthy, 0.0 = Bad/Unhealthy (Following LA.pdf logic).
     */
    public function mapToScores(Rumah $rumah)
    {
        $scores = [];

        // Pilar A: Keselamatan (Safety) - (Pondasi + Kolom + Atap) / 3
        $s1 = $this->mapBinary($rumah->pondasi, 'Ada', 'Tidak Ada');
        $s2 = $this->mapQualitative($rumah->kolom_balok);
        $s3 = $this->mapQualitative($rumah->konstruksi_atap);
        $scores['K1'] = ($s1 + $s2 + $s3) / 3;

        // Pilar B: Kesehatan (Health) - (Jendela + Ventilasi + Kamar Mandi + Jarak Air) / 4
        $h1 = $this->mapBinary($rumah->jendela, 'Ada', 'Tidak Ada');
        $h2 = $this->mapBinary($rumah->ventilasi, 'Ada', 'Tidak Ada');
        $h3 = $this->mapHealthSanitation($rumah->kamar_mandi);
        $h4 = $this->mapBinary($rumah->jarak_sumber_air, 'Lebih dari 10 meter', 'Kurang dari 10 meter');
        $scores['K2'] = ($h1 + $h2 + $h3 + $h4) / 4;

        // Pilar C: Kepadatan (Density) - Raw m2/person
        $scores['K3'] = $this->calculateDensityValue($rumah);

        // Pilar D: Komponen (Material) - Hierarchical Sub-Inference
        $scores['K4'] = $this->calculatePilarDScore($rumah);

        return $scores;
    }

    private function mapBinary($value, $goodValue, $badValue)
    {
        if ($value === $goodValue) return 1.0;
        if ($value === $badValue) return 0.0;
        return 0.5; 
    }

    private function mapQualitative($value)
    {
        $v = strtolower($value);
        if (str_contains($v, 'baik') || str_contains($v, 'ringan')) return 1.0;
        if (str_contains($v, 'sedang') || str_contains($v, 'sebagian')) return 0.5;
        if (str_contains($v, 'berat') || str_contains($v, 'seluruhnya')) return 0.0;
        return 0.5;
    }

    private function mapHealthSanitation($value)
    {
        if ($value === 'Sendiri') return 1.0;
        if ($value === 'Bersama / MCK Komunal') return 0.5;
        return 0.0; // Tidak Ada
    }

    private function mapMaterialAtap($v)
    {
        $map = [
            'Genteng Beton / Keramik' => 1.0,
            'Genteng Tanah Liat' => 0.75,
            'Seng' => 0.5,
            'Asbes' => 0.25,
            'Daun / Rumbia / Ijuk' => 0.0,
        ];
        return $map[$v] ?? 0.5;
    }

    private function mapMaterialDinding($v)
    {
        $map = [
            'Bata Diplester / Tembok Permanen' => 1.0,
            'Bata Tanpa Plester' => 0.75,
            'Semi Permanen (Triplek, dll)' => 0.5,
            'Kayu Papan' => 0.25,
            'Bambu / Anyaman' => 0.0,
        ];
        return $map[$v] ?? 0.5;
    }

    private function mapMaterialLantai($v)
    {
        $map = [
            'Granit / Ubin Berkualitas' => 1.0,
            'Keramik' => 0.75,
            'Plester Semen' => 0.5,
            'Bambu / Kayu Kasar' => 0.25,
            'Tanah' => 0.0,
        ];
        return $map[$v] ?? 0.5;
    }

    private function calculateDensityValue(Rumah $rumah)
    {
        $rumah->load('penduduk');
        // Tambahkan +1 untuk menyertakan Kepala Keluarga (KK) sendiri
        $numPeople = ($rumah->penduduk->jumlah_tanggungan ?? 0) + 1;
        
        if ($numPeople <= 0) $numPeople = 1;
        return $rumah->luas_bangunan / $numPeople;
    }

    private function calculatePilarDScore(Rumah $rumah)
    {
        // 1. Crisp values for Material and Kondisi
        $m_a = $this->mapMaterialAtap($rumah->material_atap);
        $m_d = $this->mapMaterialDinding($rumah->material_dinding);
        $m_l = $this->mapMaterialLantai($rumah->material_lantai);

        $k_a = $this->mapQualitative($rumah->kondisi_atap);
        $k_d = $this->mapQualitative($rumah->kondisi_dinding);
        $k_l = $this->mapQualitative($rumah->kondisi_lantai);

        // 2. Fuzzify Inputs
        $f_m_a = $this->fuzzifyMaterial($m_a);
        $f_m_d = $this->fuzzifyMaterial($m_d);
        $f_m_l = $this->fuzzifyMaterial($m_l);

        $f_k_a = $this->fuzzifyKondisi($k_a);
        $f_k_d = $this->fuzzifyKondisi($k_d);
        $f_k_l = $this->fuzzifyKondisi($k_l);

        // 3. Evaluate Rules for each Component Kualitas
        $q_a = $this->evaluateKualitasRules($f_m_a, $f_k_a);
        $q_d = $this->evaluateKualitasRules($f_m_d, $f_k_d);
        $q_l = $this->evaluateKualitasRules($f_m_l, $f_k_l);

        // 4. Evaluate Rules for Pilar D Aggregation
        $pilarD = $this->evaluatePilarDRules($q_a, $q_l, $q_d);

        // 5. Kembalikan nilai Alpha tertinggi secara langsung (Max-Membership) agar sama persis dengan PDF
        return max($pilarD);
    }

    private function fuzzifyMaterial($x)
    {
        return [
            'Rendah' => $this->calculateMembership($x, [0.0, 0.0, 0.4]),
            'Sedang' => $this->calculateMembership($x, [0.3, 0.5, 0.7]),
            'Tinggi' => $this->calculateMembership($x, [0.6, 0.85, 1.0])
        ];
    }

    private function fuzzifyKondisi($x)
    {
        return [
            'Buruk' => $this->calculateMembership($x, [0.0, 0.0, 0.4]),
            'Sedang' => $this->calculateMembership($x, [0.3, 0.5, 0.7]),
            'Baik' => $this->calculateMembership($x, [0.6, 0.85, 1.0])
        ];
    }

    private function evaluateKualitasRules($mat, $kon)
    {
        $out = ['Buruk' => 0.0, 'Sedang' => 0.0, 'Baik' => 0.0];
        
        // Rendah x Buruk -> Buruk
        $out['Buruk'] = max($out['Buruk'], min($mat['Rendah'], $kon['Buruk']));
        // Rendah x Sedang -> Buruk
        $out['Buruk'] = max($out['Buruk'], min($mat['Rendah'], $kon['Sedang']));
        // Rendah x Baik -> Sedang
        $out['Sedang'] = max($out['Sedang'], min($mat['Rendah'], $kon['Baik']));
        
        // Sedang x Buruk -> Buruk
        $out['Buruk'] = max($out['Buruk'], min($mat['Sedang'], $kon['Buruk']));
        // Sedang x Sedang -> Sedang
        $out['Sedang'] = max($out['Sedang'], min($mat['Sedang'], $kon['Sedang']));
        // Sedang x Baik -> Baik
        $out['Baik'] = max($out['Baik'], min($mat['Sedang'], $kon['Baik']));
        
        // Tinggi x Buruk -> Sedang
        $out['Sedang'] = max($out['Sedang'], min($mat['Tinggi'], $kon['Buruk']));
        // Tinggi x Sedang -> Baik
        $out['Baik'] = max($out['Baik'], min($mat['Tinggi'], $kon['Sedang']));
        // Tinggi x Baik -> Baik
        $out['Baik'] = max($out['Baik'], min($mat['Tinggi'], $kon['Baik']));

        return $out;
    }

    private function evaluatePilarDRules($q_a, $q_l, $q_d)
    {
        $pilarD = ['Buruk' => 0.0, 'Sedang' => 0.0, 'Baik' => 0.0];
        $states = ['Buruk', 'Sedang', 'Baik'];
        
        foreach ($states as $a) {
            foreach ($states as $l) {
                foreach ($states as $d) {
                    $alpha = min($q_a[$a], $q_l[$l], $q_d[$d]);
                    if ($alpha > 0) {
                        $burukCount = ($a === 'Buruk' ? 1 : 0) + ($l === 'Buruk' ? 1 : 0) + ($d === 'Buruk' ? 1 : 0);
                        $baikCount = ($a === 'Baik' ? 1 : 0) + ($l === 'Baik' ? 1 : 0) + ($d === 'Baik' ? 1 : 0);
                        
                        if ($burukCount >= 2 || ($burukCount == 1 && $baikCount <= 1)) {
                            $out = 'Buruk';
                        } elseif ($baikCount >= 2) {
                            $out = 'Baik';
                        } else {
                            $out = 'Sedang';
                        }
                        
                        $pilarD[$out] = max($pilarD[$out], $alpha);
                    }
                }
            }
        }
        return $pilarD;
    }

    private function defuzzifyPilarD($inferredResult)
    {
        $sumNumerator = 0;
        $sumDenominator = 0;
        
        $sets = [
            'Buruk' => [0.0, 0.0, 0.4],
            'Sedang' => [0.3, 0.5, 0.7],
            'Baik' => [0.6, 1.0, 1.0]
        ];

        for ($z = 0; $z <= 1.0; $z += 0.01) {
            $muCombine = 0;
            foreach ($inferredResult as $setName => $alpha) {
                $muZ = $this->calculateMembership($z, $sets[$setName]);
                $muRule = min($muZ, $alpha);
                $muCombine = max($muCombine, $muRule);
            }
            $sumNumerator += $z * $muCombine;
            $sumDenominator += $muCombine;
        }

        return $sumDenominator == 0 ? 0 : ($sumNumerator / $sumDenominator);
    }

    private function calculateMembership($x, $params)
    {
        [$a, $b, $c] = $params;
        // Left shoulder
        if ($a == $b && $x <= $a) return 1.0;
        // Right shoulder
        if ($b == $c && $x >= $c) return 1.0;
        
        if ($x <= $a || $x >= $c) return 0.0;
        if ($x == $b) return 1.0;
        if ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
        if ($x > $b && $x < $c) return ($c - $x) / ($c - $b);
        
        return 0.0;
    }

    public function runAssessment($pendudukId, $periode)
    {
        $penilaian = \App\Models\Penilaian::updateOrCreate(
            ['penduduk_id' => $pendudukId, 'periode' => $periode],
            [
                'user_id' => auth()->id() ?? (\App\Models\User::first()->id ?? 1),
                'tanggal_penilaian' => now(), 
                'status' => 'DIPROSES'
            ]
        );

        $rumah = Rumah::where('penduduk_id', $pendudukId)->first();
        if (!$rumah) return null;

        $inputScores = $this->mapToScores($rumah);

        foreach ($inputScores as $kriteriaCode => $nilai) {
            $kriteria = \App\Models\Kriteria::where('kode', $kriteriaCode)->first();
            if ($kriteria) {
                \App\Models\NilaiKriteria::updateOrCreate(
                    ['penilaian_id' => $penilaian->id, 'kriteria_id' => $kriteria->id],
                    ['nilai_input' => $nilai]
                );
            }
        }

        $engine = app(\App\Services\Fuzzy\MamdaniEngine::class);
        $hasil = $engine->calculate($penilaian);

        $penilaian->update(['status' => 'SELESAI']);

        return $penilaian->load('hasilSPK');
    }
}
