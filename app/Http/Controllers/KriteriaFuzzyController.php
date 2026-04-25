<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\FuzzySet;
use App\Models\FuzzyRule;

class KriteriaFuzzyController extends Controller
{
    public function index()
    {
        // Load all input criteria with their fuzzy sets
        $kriterias = Kriteria::with('fuzzySets')->orderBy('kode')->get();

        // Load output fuzzy sets (for defuzzification display)
        $outputSets = FuzzySet::whereNull('kriteria_id')->get();

        // Load all active rules with their conditions
        $rules = FuzzyRule::with('details.kriteria')
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        // Group rules by output for easier display
        $rulesLayak     = $rules->where('output_set', 'LAYAK');
        $rulesTidakLayak = $rules->where('output_set', 'TIDAK LAYAK');

        return view('kriteria-fuzzy.index', compact(
            'kriterias', 'outputSets', 'rules', 'rulesLayak', 'rulesTidakLayak'
        ));
    }
}
