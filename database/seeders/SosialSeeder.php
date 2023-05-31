<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sosial;

class SosialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sosial::create([
            'nama_sosial' => "-"
        ]);
        Sosial::create([
            'nama_sosial' => "Bantuan Pangan Non Tunai"
        ]);
        Sosial::create([
            'nama_sosial' => "Bansos PKH"
        ]);
        Sosial::create([
            'nama_sosial' => "Kartu Indonesia Pintar"
        ]);
        Sosial::create([
            'nama_sosial' => "Kartu Indonesia Sehat"
        ]);
        Sosial::create([
            'nama_sosial' => "BLT Dana Desa"
        ]);
        Sosial::create([
            'nama_sosial' => "Kartu Prakerja"
        ]);
    }
}
