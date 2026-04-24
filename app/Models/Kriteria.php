<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria';

    protected $fillable = ['nama', 'kode', 'min_value', 'max_value', 'satuan'];

    public function fuzzySets()
    {
        return $this->hasMany(FuzzySet::class);
    }

    public function nilaiKriteria()
    {
        return $this->hasMany(NilaiKriteria::class);
    }
}
