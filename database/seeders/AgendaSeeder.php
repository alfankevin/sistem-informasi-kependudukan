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
            'judul_agenda' => "Pengabdian Masyarakat",
            'tanggal_agenda' => "2023-05-11",
            'deskripsi_agenda' => "Pengabdian Masyarakat oleh Mahasiswa Politeknik Negeri Malang kepada RW 5 Tanjungrejo, Sukun, Kota Malang. Melalui kerjasama ini, Tim Mahasiswa POLINEMA merancang dan membangun sebuah website yang mencerminkan identitas dan kebutuhan RW.",
            'gambar_agenda' => "pengabdian.jpeg"
        ]);
        Agenda::create([
            'judul_agenda' => "Peringatan HUT Republik Indonesia",
            'tanggal_agenda' => "2022-08-13",
            'deskripsi_agenda' => "Rangkaian kegiatan dalam menyemarakkan peringatan HUT RI tahun 2022 di RW 05 antara lain: 1.Lomba tanggal 13, 14, dan 17 Agustus 2022 yang terdiri dari lomba anak-anak dan ibu-ibu. 2.Barikan atau yang disebut dengan malam tasyakuran pada tanggal 16 Agustus",
            'gambar_agenda' => "hut.jpg",
        ]);
        Agenda::create([
            'judul_agenda' => "Peringatan Maulid Nabi",
            'tanggal_agenda' => "2022-10-23",
            'deskripsi_agenda' => "Peringatan Maulid Nabi di RW 05 dilaksanakan pada tanggal 23 Oktober 2022 dengan menggandeng beberapa organisasi masyarakat antara lain Muslimat, Muslimin, dan Karang taruna dengan dihadiri warga RW 05.",
            'gambar_agenda' => "maulid.jpg"
        ]);
        Agenda::create([
            'judul_agenda' => "Vaksinasi Covid-19",
            'tanggal_agenda' => "2023-03-10",
            'deskripsi_agenda' => "Vaksinasi Covid-19 RW 05 diadakan oleh Seksi Kepemudaan RW 05 dan Karang Taruna Artanwema (bekerja sama dengan ILUNA Community dan LANAL Malang) pada tanggal 10 Maret 2023. Vaksinasi tidak hanya diikuti oleh warga RW 05, tetapi juga untuk umum.",
            'gambar_agenda' => "vaksin.jpg"
        ]);
        Agenda::create([
            'judul_agenda' => "Lomba Patrol antar RW",
            'tanggal_agenda' => "2023-04-15",
            'deskripsi_agenda' => "Lomba Patrol antar RW kelurahan Tanjungrejo dilaksanakan di Bangun Indah Graha Depo Bangunan I.R. Rais pada tanggal 15 April 2023. Tim Patrol Artanwema RW 05 berhasil menjadi juara I.",
            'gambar_agenda' => "patrol.jpg"
        ]);
    }
}
