<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OCR extends Model
{
    use HasFactory;
    protected $table = 'ocr_result';
    protected $guarded = ['id'];
}
