<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';

    protected $fillable = ['nama', 'kode', 'batas_wilayah'];

    protected $casts = [
        'batas_wilayah' => 'json',
    ];

    public function penduduk()
    {
        return $this->hasMany(Penduduk::class);
    }
}
