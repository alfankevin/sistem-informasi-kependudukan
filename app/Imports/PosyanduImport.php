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

    protected $bulanPosyandu;

    public function __construct($bulanPosyandu)
    {
        // Tambahkan -01 supaya cocok untuk tipe DATE
        $this->bulanPosyandu = $bulanPosyandu . '-01';
    }
    public function model(array $row)
    {
        $penduduk = Penduduk::whereRaw('LOWER(nama) = ?', [strtolower($row['nama'])])->first();


        Posyandu::updateOrCreate(['id_penduduk' => $penduduk->id,
            'bulan_posyandu' => $this->bulanPosyandu],
            [
                'id_penduduk' => $penduduk->id,
                'usia' => $this->hitungUsiaDalamBulan($penduduk->tanggal_lahir, $this->bulanPosyandu),
                'berat_badan' => (float) $row['berat_badan_kg'],
                'tinggi_badan' => (float) $row['panjang_badan_cm'],
                'lingkar_lengan_atas' => (float) $row['lingkar_lengan_atas_cm'],
                'lingkar_lengan_bawah' => (float) $row['lingkar_lengan_bawah_cm'],
                'lingkar_dada' => (float) $row['lingkar_dada_cm'],
                'lingkar_perut' => (float) $row['lingkar_perut_cm'],
                'lingkar_kepala' => (float) $row['lingkar_kepala_cm'],
                'gizi' => 0,
                'bulan_posyandu' => $this->bulanPosyandu,
            ]
        );
    }

    public function hitungUsiaDalamBulan($tanggalLahir, $bulanPosyandu)
    {
        $lahir = new DateTime($tanggalLahir);
        $posyandu = new DateTime($bulanPosyandu);

        $tahun = $posyandu->format('Y') - $lahir->format('Y');
        $bulan = $posyandu->format('m') - $lahir->format('m');
        $totalBulan = ($tahun * 12) + $bulan;

        // Kalau hari ini belum lewat tanggal lahir di bulan ini, kurangi 1
        if ($posyandu->format('d') < $lahir->format('d')) {
            $totalBulan--;
        }

        return $totalBulan;
    }

    public function uniqueBy()
    {
        return 'id_penduduk'; // atau kolom lain yang ingin kamu jadikan acuan update
    }
}
