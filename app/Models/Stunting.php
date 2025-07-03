<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stunting extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'posyandu_id',
        'status_gizi',
        'nilai',
        'kategori'
    ];

    protected $casts = [
        'status_gizi' => 'float',
        'nilai' => 'float',
    ];

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');
    }
}
