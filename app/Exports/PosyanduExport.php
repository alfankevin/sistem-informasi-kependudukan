<?php

namespace App\Exports;

use App\Models\Posyandu;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PosyanduExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $bulanPosyandu;

    public function __construct($bulanPosyandu)
    {
        $this->bulanPosyandu = $bulanPosyandu;
    }

    public function collection()
    {
        $parsedMonth = Carbon::parse($this->bulanPosyandu);

        return Posyandu::join('penduduk', 'penduduk.id', 'posyandu.id_penduduk')
            ->join('stuntings', 'posyandu.id', 'stuntings.posyandu_id')
            ->join('kartu_keluarga', 'penduduk.no_kk', 'kartu_keluarga.no_kk')
            ->where('penduduk.tanggal_lahir', '>=', Carbon::parse($parsedMonth)->subYears(3)->toDateString()) // Tambahkan ini
            ->whereYear('posyandu.bulan_posyandu', $parsedMonth->year)
            ->whereMonth('posyandu.bulan_posyandu', $parsedMonth->month)
            ->select([
                'penduduk.no_kk',
                'penduduk.nik',
                'penduduk.nama',
                'penduduk.tanggal_lahir',
                'penduduk.jenis_kelamin',
                'penduduk.tanggal_lahir',
                'kartu_keluarga.alamat',
                'posyandu.usia',
                'posyandu.berat_badan',
                'posyandu.tinggi_badan',
                'posyandu.lingkar_lengan_atas',
                'posyandu.lingkar_lengan_bawah',
                'posyandu.lingkar_dada',
                'posyandu.lingkar_perut',
                'posyandu.lingkar_kepala',
                'stuntings.status_gizi',
                'stuntings.nilai',
                'stuntings.kategori',
            ])->get();
    }

    public function headings(): array
    {
        return [
            'No KK',
            'NIK',
            'Nama',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Usia',
            'Berat Badan (kg)',
            'Panjang Badan (cm)',
            'Lingkar Lengan Atas (cm)',
            'Lingkar Lengan Bawah (cm)',
            'Lingkar Dada (cm)',
            'Lingkar Perut (cm)',
            'Lingkar Kepala',
            'Status Gizi',
            'Nilai Perangkingan',
            'Kategori Risiko'
        ];
    }

    public function columnFormats(): array
{
    return [
        'A' => NumberFormat::FORMAT_NUMBER_00, // No KK
        'B' => NumberFormat::FORMAT_NUMBER_00,     // NIK
    ];
}
}
