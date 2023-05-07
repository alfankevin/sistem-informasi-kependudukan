<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Agenda;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Agenda::create([
            'judul_agenda' => "Peringatan Hari Kemerdekaan",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "Gambar",
        ]);
        Agenda::create([
            'judul_agenda' => "Pengobatan Gratis",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "Gambar"
        ]);
        Agenda::create([
            'judul_agenda' => "Takjil Gratis",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "Gambar"
        ]);
        Agenda::create([
            'judul_agenda' => "Khitanan Masal",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "Gambar"
        ]);
        Agenda::create([
            'judul_agenda' => "Donor Darah",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "Gambar"
        ]);
        Agenda::create([
            'judul_agenda' => "Kerja Bakti",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "Gambar"
        ]);
        Agenda::create([
            'judul_agenda' => "Kegiatan Ronda",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "Gambar"
        ]);
        Agenda::create([
            'judul_agenda' => "Penyuluhan",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "Gambar"
        ]);
    }
}
