<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaksinSeeder extends Seeder
{
    public function run()
    {
        DB::table('vaksins')->insert([
            [
                'nama_vaksin' => 'BCG',
                'deskripsi' => 'Vaksin untuk mencegah tuberkulosis',
                'usia_pemberian' => '0-1 bulan',
                'dosis_total' => 1,
                'interval' => '-',
            ],
            [
                'nama_vaksin' => 'Polio',
                'deskripsi' => 'Vaksin untuk mencegah poliomyelitis',
                'usia_pemberian' => '0, 2, 3, 4 bulan',
                'dosis_total' => 4,
                'interval' => '1 bulan',
            ],
            [
                'nama_vaksin' => 'DPT',
                'deskripsi' => 'Vaksin untuk difteri, pertusis, tetanus',
                'usia_pemberian' => '2, 3, 4 bulan',
                'dosis_total' => 3,
                'interval' => '1 bulan',
            ],
        ]);
    }
}
