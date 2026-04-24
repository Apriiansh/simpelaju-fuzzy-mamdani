<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuzzyRuleDetail extends Model
{
    protected $table = 'fuzzy_rule_details';

    protected $fillable = ['fuzzy_rule_id', 'kriteria_id', 'fuzzy_set_nama'];

    public function fuzzyRule()
    {
        return $this->belongsTo(FuzzyRule::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
