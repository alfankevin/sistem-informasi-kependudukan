<?php

namespace App\Imports;

use App\Models\Penduduk;
use App\Models\Posyandu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use DateTime;

class PosyanduImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $penduduk = Penduduk::whereRaw('LOWER(nama) = ?', [strtolower($row['nama'])])->first();

        if (!$penduduk) {
            return null;
        }

        Posyandu::updateOrCreate(
            ['id_penduduk' => $penduduk->id],
            [
                'usia' => $this->hitungUsiaDalamBulan($penduduk->tanggal_lahir),
                'berat_badan' => $row['berat_badan_kg'],
                'tinggi_badan' => $row['panjang_badan_cm'],
                'lingkar_lengan_atas' => $row['lingkar_lengan_atas_cm'],
                'lingkar_lengan_bawah' => $row['lingkar_lengan_bawah_cm'],
                'lingkar_dada' => $row['lingkar_dada_cm'],
                'lingkar_perut' => $row['lingkar_perut_cm'],
                'lingkar_kepala' => $row['lingkar_kepala_cm'],
                'gizi' => 0
            ]
        );
    }

    public function hitungUsiaDalamBulan($tanggalLahir)
    {
        $lahir = new DateTime($tanggalLahir);
        $hariIni = new DateTime();

        $tahun = $hariIni->format('Y') - $lahir->format('Y');
        $bulan = $hariIni->format('m') - $lahir->format('m');
        $totalBulan = ($tahun * 12) + $bulan;

        // Kalau hari ini belum lewat tanggal lahir di bulan ini, kurangi 1
        if ($hariIni->format('d') < $lahir->format('d')) {
            $totalBulan--;
        }

        return $totalBulan;
    }

    public function uniqueBy()
    {
        return 'id_penduduk'; // atau kolom lain yang ingin kamu jadikan acuan update
    }
}
