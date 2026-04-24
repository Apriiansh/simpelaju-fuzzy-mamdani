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
        if (str_contains($v, 'baik')) return 1.0;
        if (str_contains($v, 'ringan')) return 0.75;
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
        $numPeople = ($rumah->penduduk->jumlah_tanggungan ?? 0);
        // Pastikan tidak pembagian dengan nol
        if ($numPeople <= 0) $numPeople = 1;
        return $rumah->luas_bangunan / $numPeople;
    }

    private function calculatePilarDScore(Rumah $rumah)
    {
        $atapQuality = $this->getComponentQuality(
            $this->getMaterialCategory($rumah->material_atap, 'atap'),
            $this->getConditionCategory($rumah->kondisi_atap)
        );
        $dindingQuality = $this->getComponentQuality(
            $this->getMaterialCategory($rumah->material_dinding, 'dinding'),
            $this->getConditionCategory($rumah->kondisi_dinding)
        );
        $lantaiQuality = $this->getComponentQuality(
            $this->getMaterialCategory($rumah->material_lantai, 'lantai'),
            $this->getConditionCategory($rumah->kondisi_lantai)
        );

        $finalStatus = $this->aggregatePilarD($atapQuality, $lantaiQuality, $dindingQuality);

        return match($finalStatus) {
            'Buruk' => 0.2,
            'Sedang' => 0.5,
            'Baik' => 0.8,
            default => 0.5
        };
    }

    private function getMaterialCategory($v, $type)
    {
        $score = match($type) {
            'atap' => $this->mapMaterialAtap($v),
            'dinding' => $this->mapMaterialDinding($v),
            'lantai' => $this->mapMaterialLantai($v),
            default => 0.5
        };
        if ($score <= 0.4) return 'Rendah';
        if ($score <= 0.7) return 'Sedang';
        return 'Tinggi';
    }

    private function getConditionCategory($v)
    {
        $score = $this->mapQualitative($v);
        if ($score <= 0.4) return 'Buruk';
        if ($score <= 0.7) return 'Sedang';
        return 'Baik';
    }

    private function getComponentQuality($mat, $cond)
    {
        if ($mat === 'Rendah') {
            return ($cond === 'Baik') ? 'Sedang' : 'Buruk';
        }
        if ($mat === 'Sedang') {
            if ($cond === 'Buruk') return 'Buruk';
            if ($cond === 'Sedang') return 'Sedang';
            return 'Baik';
        }
        if ($mat === 'Tinggi') {
            if ($cond === 'Buruk') return 'Sedang';
            return 'Baik';
        }
        return 'Sedang';
    }

    private function aggregatePilarD($a, $l, $d)
    {
        $burukCount = ($a === 'Buruk' ? 1 : 0) + ($l === 'Buruk' ? 1 : 0) + ($d === 'Buruk' ? 1 : 0);
        $baikCount = ($a === 'Baik' ? 1 : 0) + ($l === 'Baik' ? 1 : 0) + ($d === 'Baik' ? 1 : 0);

        if ($burukCount >= 1) {
            // KR1-KR7 logic: Any Buruk with another non-Baik OR multi Buruk = Buruk
            if ($burukCount >= 2 || $baikCount <= 1) return 'Buruk';
            return 'Sedang'; // One Buruk but others are Baik (KR23, etc)
        }
        
        if ($baikCount >= 2) return 'Baik';
        return 'Sedang';
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
