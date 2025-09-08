<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosyanduVaksin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'posyandu_id',
        'vaksin_id',
        'dosis_ke',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'posyandu_id' => 'integer',
        'vaksin_id' => 'integer',
    ];

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    public function vaksin()
    {
        return $this->belongsTo(Vaksin::class);
    }
}
