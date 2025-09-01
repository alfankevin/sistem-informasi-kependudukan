<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengurusWilayah extends Model
{
    use HasFactory;
    protected $table = 'pengurus_wilayah';
    protected $guarded = ['id'];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
