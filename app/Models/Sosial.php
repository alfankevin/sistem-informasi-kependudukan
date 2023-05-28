<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sosial extends Model
{
    use HasFactory;
    protected $table = 'sosial';
    protected $guarded = ['id'];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }
}
