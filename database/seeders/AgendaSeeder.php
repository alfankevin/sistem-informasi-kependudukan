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
            'tanggal_agenda' => "2002-09-15",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "gambar.jpeg",
        ]);
        Agenda::create([
            'judul_agenda' => "Pengobatan Gratis",
            'tanggal_agenda' => "2002-09-15",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "gambar.jpeg"
        ]);
        Agenda::create([
            'judul_agenda' => "Takjil Gratis",
            'tanggal_agenda' => "2002-09-15",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "gambar.jpeg"
        ]);
        Agenda::create([
            'judul_agenda' => "Khitanan Masal",
            'tanggal_agenda' => "2002-09-15",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "gambar.jpeg"
        ]);
        Agenda::create([
            'judul_agenda' => "Donor Darah",
            'tanggal_agenda' => "2002-09-15",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "gambar.jpeg"
        ]);
        Agenda::create([
            'judul_agenda' => "Kerja Bakti",
            'tanggal_agenda' => "2002-09-15",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "gambar.jpeg"
        ]);
        Agenda::create([
            'judul_agenda' => "Kegiatan Ronda",
            'tanggal_agenda' => "2002-09-15",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "gambar.jpeg"
        ]);
        Agenda::create([
            'judul_agenda' => "Penyuluhan",
            'tanggal_agenda' => "2002-09-15",
            'deskripsi_agenda' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, architecto.",
            'gambar_agenda' => "gambar.jpeg"
        ]);
    }
}
