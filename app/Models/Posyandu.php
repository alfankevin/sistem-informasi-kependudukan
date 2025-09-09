<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;
    protected $table = 'posyandu';
    protected $guarded = ['id'];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'id_penduduk', 'id');
    }

    public function posyanduVaksin()
    {
        return $this->hasMany(PosyanduVaksin::class, 'posyandu_id', 'id');
    }

    public function posyanduVitamin()
    {
        return $this->hasMany(PosyanduVitamin::class, 'posyandu_id', 'id');
    }

    public function posyanduPemeriksaan()
    {
        return $this->hasMany(PosyanduPemeriksaan::class, 'posyandu_id', 'id');
    }
}
