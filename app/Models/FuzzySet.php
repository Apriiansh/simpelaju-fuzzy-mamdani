<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuzzySet extends Model
{
    protected $table = 'fuzzy_sets';

    protected $fillable = ['kriteria_id', 'nama', 'tipe', 'parameter'];

    protected $casts = [
        'parameter' => 'json',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
