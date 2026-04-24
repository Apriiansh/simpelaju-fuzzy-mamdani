<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuzzyRule extends Model
{
    protected $table = 'fuzzy_rules';

    protected $fillable = ['nomor_rule', 'operator', 'output_set', 'is_active'];

    public function details()
    {
        return $this->hasMany(FuzzyRuleDetail::class);
    }
}
