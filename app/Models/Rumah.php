<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    protected $table = 'rumah';

    protected $fillable = [
        'penduduk_id', 
        'pondasi', 'kolom_balok', 'konstruksi_atap', // Pilar A
        'jendela', 'ventilasi', 'kamar_mandi', 'jarak_sumber_air', // Pilar B
        'luas_bangunan', // Pilar C
        'material_atap', 'kondisi_atap', // Pilar D
        'material_dinding', 'kondisi_dinding',
        'material_lantai', 'kondisi_lantai',
        'status_kepemilikan', 'foto_rumah'
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }
}
