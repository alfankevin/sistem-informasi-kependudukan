<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;
    protected $table = 'penduduk';
    protected $guarded = ['id'];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'no_kk', 'no_kk');
    }

    public function sosial()
    {
        return $this->hasMany(Sosial::class);
    }

    public function posyandu()
    {
        return $this->hasMany(Posyandu::class, 'id_penduduk', 'id');
    }

    public function pengurus()
    {
        return $this->hasOne(PengurusWilayah::class, 'penduduk_id');
    }
}
