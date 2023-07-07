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
            'harga_umkm' => "25000",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
        Potensi::create([
            'nama_umkm' => "UMKM Rujak",
            'harga_umkm' => "25000",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
        Potensi::create([
            'nama_umkm' => "UMKM Bakso",
            'harga_umkm' => "25000",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
        Potensi::create([
            'nama_umkm' => "UMKM Cooey",
            'harga_umkm' => "25000",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
        Potensi::create([
            'nama_umkm' => "UMKM Bakery",
            'harga_umkm' => "25000",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
        Potensi::create([
            'nama_umkm' => "UMKM Cakeiz",
            'harga_umkm' => "25000",
            'deskripsi_umkm' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'sosial_media' => "Sosial Media",
            'gambar_umkm' => "gambar.jpeg"
        ]);
    }
}
