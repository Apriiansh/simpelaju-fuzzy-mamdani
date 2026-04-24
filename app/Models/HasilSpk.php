<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSpk extends Model
{
    protected $table = 'hasil_spk';

    protected $fillable = [
        'penilaian_id', 'nilai_defuzzifikasi', 'kategori_kelayakan', 
        'rekomendasi', 'detail_perhitungan'
    ];

    protected $casts = [
        'detail_perhitungan' => 'json',
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }
}
