<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class pendudukExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Penduduk::select('no_kk', 'nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'golongan_darah', 'agama', 'status_perkawinan', 'status_keluarga', 'pekerjaan', 'alamat', 'rt', 'keterangan', 'id_sosial')->get();

        // return Penduduk::all()->except(['id']);
        return $data;
    }

    public function headings(): array
    {
        return [
            'no_kk',
            'nik',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'golongan_darah',
            'agama',
            'status_perkawinan',
            'status_keluarga',
            'pekerjaan',
            'alamat',
            'rt',
            'keterangan',
            'id_sosial',
        ];
    }
}
