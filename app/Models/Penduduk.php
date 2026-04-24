<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $table = 'penduduk';

    protected $fillable = [
        'nik', 'nama_lengkap', 'alamat', 'kelurahan_id', 
        'no_telepon', 'status_pernikahan', 'jumlah_tanggungan', 
        'penghasilan', 'latitude', 'longitude'
    ];

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function rumah()
    {
        return $this->hasOne(Rumah::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}
