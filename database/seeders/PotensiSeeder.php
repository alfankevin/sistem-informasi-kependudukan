<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Potensi;

class PotensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Potensi::create([
            'nama_umkm' => "UMKM Indah",
            'alamat_umkm' => "Jl. Saturn No. 256",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
        Potensi::create([
            'nama_umkm' => "UMKM Rujak",
            'alamat_umkm' => "Jl. Saturn No. 256",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
        Potensi::create([
            'nama_umkm' => "UMKM Bakso",
            'alamat_umkm' => "Jl. Saturn No. 256",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
        Potensi::create([
            'nama_umkm' => "UMKM Cooey",
            'alamat_umkm' => "Jl. Saturn No. 256",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
        Potensi::create([
            'nama_umkm' => "UMKM Bakery",
            'alamat_umkm' => "Jl. Saturn No. 256",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
        Potensi::create([
            'nama_umkm' => "UMKM Cakeiz",
            'alamat_umkm' => "Jl. Saturn No. 256",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
    }
}
