<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VitaminSeeder extends Seeder
{
    public function run()
    {
        DB::table('vitamins')->insert([
            [
                'nama_vitamin' => 'Vitamin A Biru',
                'deskripsi' => 'Untuk bayi usia 6-11 bulan',
                'usia_pemberian' => '< 1 tahun',
                'dosis' => '100.000 IU',
            ],
            [
                'nama_vitamin' => 'Vitamin A Merah',
                'deskripsi' => 'Untuk anak usia 12-59 bulan',
                'usia_pemberian' => '> 1 tahun',
                'dosis' => '200.000 IU',
            ],
        ]);
    }
}
