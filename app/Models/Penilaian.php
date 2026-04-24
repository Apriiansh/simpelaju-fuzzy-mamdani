<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaian';

    protected $fillable = ['penduduk_id', 'user_id', 'periode', 'tanggal_penilaian', 'status'];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nilaiKriteria()
    {
        return $this->hasMany(NilaiKriteria::class);
    }

    public function hasilSPK()
    {
        return $this->hasOne(HasilSpk::class);
    }
}
