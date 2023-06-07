<?php

namespace App\Imports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class pendudukImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return Penduduk::firstOrCreate(['nik' => $row['nik']],
            [
            'no_kk' => $row['no_kk'],
            'nik' => $row['nik'],
            'nama' => $row['nama'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $this->transformDate($row['tanggal_lahir']),
            'jenis_kelamin' => $row['jenis_kelamin'],
            'golongan_darah' => $row['golongan_darah'],
            'agama' => $row['agama'],
            'status_perkawinan' => $row['status_perkawinan'],
            'status_keluarga' => $row['status_keluarga'],
            'pekerjaan' => $row['pekerjaan'],
            'alamat' => $row['alamat'],
            'rt' => $row['rt'],
            'keterangan' => $row['keterangan'],
            'id_sosial' => $row['id_sosial'],
        ]);
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int) $value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }

    public function uniqueBy()
    {
        return 'nik';
    }
}
