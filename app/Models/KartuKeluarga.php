<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    use HasFactory;
    protected $table = 'kartu_keluarga';
    protected $guarded = ['id'];

    public function penduduk()
    {
        return $this->hasMany(Penduduk::class, 'no_kk', 'no_kk');
    }
}
