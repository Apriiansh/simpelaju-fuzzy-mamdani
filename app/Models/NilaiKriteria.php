<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiKriteria extends Model
{
    protected $table = 'nilai_kriteria';

    protected $fillable = ['penilaian_id', 'kriteria_id', 'nilai_input', 'hasil_fuzzifikasi'];

    protected $casts = [
        'hasil_fuzzifikasi' => 'json',
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
