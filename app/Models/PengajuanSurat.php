<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_surat';
    protected $guarded = ['id'];

    public function historiSurat() {
        return $this->belongsTo(HistoriSurat::class, 'surat_pengajuan_id');
    }
}
