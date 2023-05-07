<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organisasi;

class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organisasi::create([
            'nama_ormas' => "RT (Rukun Tetangga)",
            'gambar_ormas' => "Gambar"
        ]);
        Organisasi::create([
            'nama_ormas' => "RW (Rukun Warga)",
            'gambar_ormas' => "Gambar"
        ]);
        Organisasi::create([
            'nama_ormas' => "Karang Taruna",
            'gambar_ormas' => "Gambar"
        ]);
        Organisasi::create([
            'nama_ormas' => "Posyandu",
            'gambar_ormas' => "Gambar"
        ]);
        Organisasi::create([
            'nama_ormas' => "PKK (Pembina Kesejahteraan Keluarga)",
            'gambar_ormas' => "Gambar"
        ]);
        Organisasi::create([
            'nama_ormas' => "Sistem Keamanan Lingkungan",
            'gambar_ormas' => "Gambar"
        ]);
        Organisasi::create([
            'nama_ormas' => "Ketakmiran Masjid",
            'gambar_ormas' => "Gambar"
        ]);
    }
}
