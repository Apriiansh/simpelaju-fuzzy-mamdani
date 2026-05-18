<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $table = 'penduduk';

    protected $fillable = [
        'nik', 'nama_lengkap', 'alamat', 'kelurahan_id', 
        'no_telepon', 'status_pernikahan', 'jumlah_tanggungan', 
        'penghasilan', 'rt', 'rw', 'usia', 'pendidikan_terakhir', 'jenis_kelamin',
        'pekerjaan_utama', 'pernah_dapat_bantuan', 'jenis_kawasan',
        'aset_rumah_lain', 'aset_tanah_lain',
        'latitude', 'longitude'
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
