<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosyanduVitamin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'posyandu_id',
        'vitamin_id',
        'catatan',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'posyandu_id' => 'integer',
        'vitamin_id' => 'integer',
    ];

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    public function vitamin()
    {
        return $this->belongsTo(Vitamin::class);
    }
}
