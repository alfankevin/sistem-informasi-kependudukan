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
            'nama_organisasi' => "RT (Rukun Tetangga)",
            'gambar_organisasi' => "rt.png",
            'deskripsi_organisasi' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto."
        ]);
        Organisasi::create([
            'nama_organisasi' => "RW (Rukun Warga)",
            'gambar_organisasi' => "rw.jpg",
            'deskripsi_organisasi' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto."
        ]);
        Organisasi::create([
            'nama_organisasi' => "Karang Taruna",
            'gambar_organisasi' => "karangtaruna.jpeg",
            'deskripsi_organisasi' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto."
        ]);
        Organisasi::create([
            'nama_organisasi' => "Posyandu",
            'gambar_organisasi' => "posyandu.png",
            'deskripsi_organisasi' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto."
        ]);
        Organisasi::create([
            'nama_organisasi' => "PKK (Pembina Kesejahteraan Keluarga)",
            'gambar_organisasi' => "pkk.png",
            'deskripsi_organisasi' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto."
        ]);
        Organisasi::create([
            'nama_organisasi' => "Ketakmiran Masjid",
            'gambar_organisasi' => "ketakmiran.png",
            'deskripsi_organisasi' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto."
        ]);
    }
}
