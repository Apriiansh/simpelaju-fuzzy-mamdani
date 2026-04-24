<?php

namespace App\Services\Fuzzy;

use App\Models\Kriteria;
use App\Models\FuzzySet;
use App\Models\FuzzyRule;
use App\Models\Penilaian;
use App\Models\NilaiKriteria;
use App\Models\HasilSpk;

class MamdaniEngine
{
    /**
     * Run the full SPK process for a specific appraisal.
     */
    public function calculate(Penilaian $penilaian)
    {
        // 1. Fuzzification
        $fuzzifiedInput = $this->fuzzify($penilaian);

        // 2. Rule Evaluation & Inference
        $inferredResult = $this->inference($fuzzifiedInput);

        // 3. Defuzzification
        $score = $this->defuzzify($inferredResult);

        // 4. Result Interpretation
        // Threshold can be adjusted based on needs (default 50)
        // MUST MATCH DATABASE ENUM: ['TIDAK_LAYAK', 'LAYAK']
        $category = $score >= 50 ? 'LAYAK' : 'TIDAK_LAYAK';

        // 5. Save/Update HasilSpk
        return HasilSpk::updateOrCreate(
            ['penilaian_id' => $penilaian->id],
            [
                'nilai_defuzzifikasi' => $score,
                'kategori_kelayakan' => $category,
                'rekomendasi' => $category === 'LAYAK' 
                    ? 'Direkomendasikan untuk menerima bantuan RTLH.' 
                    : 'Belum memenuhi kriteria prioritas bantuan RTLH.',
                'detail_perhitungan' => [
                    'fuzzification' => $fuzzifiedInput,
                    'inference' => $inferredResult,
                    'score_raw' => $score
                ]
            ]
        );
    }

    /**
     * Map crisp inputs to fuzzy membership values.
     */
    private function fuzzify(Penilaian $penilaian)
    {
        $penilaian->load('nilaiKriteria.kriteria.fuzzySets');
        $results = [];

        foreach ($penilaian->nilaiKriteria as $nilai) {
            $kriteria = $nilai->kriteria;
            $crispValue = (float) $nilai->nilai_input;
            $memberships = [];

            foreach ($kriteria->fuzzySets as $set) {
                $memberships[$set->nama] = $this->calculateMembership(
                    $crispValue, 
                    $set->tipe, 
                    $set->parameter
                );
            }

            $results[$kriteria->nama] = $memberships;
            
            // Save individual fuzzification results for transparency
            $nilai->update(['hasil_fuzzifikasi' => $memberships]);
        }

        return $results;
    }

    /**
     * Membership function implementation (Triangular & Trapezoidal).
     */
    private function calculateMembership($x, $type, $params)
    {
        // Handle empty or invalid parameters
        if (!is_array($params) || empty($params)) return 0;

        if ($type === 'triangular' || $type === 'segitiga') {
            [$a, $b, $c] = $params;
            if ($x == $b) return 1;
            if ($x <= $a || $x >= $c) return 0;
            if ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
            if ($x > $b && $x < $c) return ($c - $x) / ($c - $b);
        }

        if ($type === 'trapezoidal' || $type === 'trapesium') {
            [$a, $b, $c, $d] = $params;
            
            // Handle shoulder cases (a=b or c=d)
            if ($a == $b && $x <= $a) return 1;
            if ($c == $d && $x >= $d) return 1;
            
            if ($x >= $b && $x <= $c) return 1;
            if ($x <= $a || $x >= $d) return 0;
            if ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
            if ($x > $c && $x < $d) return ($d - $x) / ($d - $c);
        }

        return 0;
    }

    /**
     * Evaluate rules and determine output aggregate using MIN-MAX method.
     */
    private function inference($fuzzifiedInput)
    {
        $rules = FuzzyRule::with('details.kriteria')->where('is_active', true)->get();
        $outputValues = [];

        foreach ($rules as $rule) {
            $antecedentValues = [];
            foreach ($rule->details as $detail) {
                $kriteriaName = $detail->kriteria->nama;
                $setName = $detail->fuzzy_set_nama;
                
                // Get membership value for this specific criteria set
                $val = $fuzzifiedInput[$kriteriaName][$setName] ?? 0;
                $antecedentValues[] = (float) $val;
            }

            if (empty($antecedentValues)) continue;

            // Apply Operator (Default: AND -> MIN)
            $ruleWeight = ($rule->operator === 'OR') ? max($antecedentValues) : min($antecedentValues);

            // Group by output set (e.g. 'LAYAK', 'TIDAK_LAYAK')
            // Normalizing names to underscore for safety
            $outputSet = str_replace(' ', '_', strtoupper($rule->output_set));
            $outputValues[$outputSet][] = $ruleWeight;
        }

        // Aggregate for each output set using MAX (Composition)
        $aggregated = [];
        foreach ($outputValues as $setName => $weights) {
            $aggregated[$setName] = max($weights);
        }

        return $aggregated;
    }

    /**
     * Compute final crisp score using a simplified Centroid method.
     */
    private function defuzzify($inferredResult)
    {
        $sumNumerator = 0;
        $sumDenominator = 0;
        
        // 1. Get all output sets (where kriteria_id is null)
        $outputSets = FuzzySet::whereNull('kriteria_id')->get();
        
        // 2. Iterate through 0-100 (Discretization for Centroid)
        for ($z = 0; $z <= 100; $z++) {
            $muCombine = 0;
            
            foreach ($inferredResult as $setName => $alpha) {
                // Find the corresponding fuzzy set for this inference result
                // Normalized name comparison
                $set = $outputSets->first(function($s) use ($setName) {
                    return str_replace(' ', '_', strtoupper($s->nama)) === strtoupper($setName);
                });

                if ($set) {
                    $muZ = $this->calculateMembership($z, $set->tipe, $set->parameter);
                    // Mamdani implication: min(membership, alpha)
                    $muRule = min($muZ, $alpha);
                    // Composition: max across all rules
                    $muCombine = max($muCombine, $muRule);
                }
            }
            
            $sumNumerator += $z * $muCombine;
            $sumDenominator += $muCombine;
        }

        if ($sumDenominator == 0) return 0;

        return $sumNumerator / $sumDenominator;
    }

}
