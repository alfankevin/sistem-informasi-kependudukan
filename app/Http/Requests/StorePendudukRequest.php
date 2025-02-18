<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePendudukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'import_kk' => 'required|in:0,1',
        ];

        if (request('import_kk') == 0) {
            $rules['no_kk'] = 'required|max:16';
            $rules['nik'] = 'required|max:16';
            $rules['nama'] = 'required|max:128';
            $rules['tempat_lahir'] = 'required|max:128';
            $rules['tanggal_lahir'] = 'required';
            $rules['jenis_kelamin'] = 'required';
            $rules['golongan_darah'] = 'required|max:3';
            $rules['agama'] = 'required|max:16';
            $rules['status_perkawinan'] = 'required|max:32';
            $rules['status_keluarga'] = 'required';
            $rules['pekerjaan'] = 'required|max:128';
            $rules['keterangan'] = 'required|max:128';
            $rules['id_sosial'] = 'required';
        } else {
            $rules['penduduk.*.nik'] = 'required|max:16';
            $rules['no_kk'] = 'required|max:16';
            $rules['alamat'] = 'required|max:256';
            $rules['rt_rw'] = 'required|max:8';
            $rules['kode_pos'] = 'required|max:8';
            $rules['kelurahan'] = 'required|max:128';
            $rules['kecamatan'] = 'required|max:128';
            $rules['kabupaten'] = 'required|max:128';
            $rules['provinsi'] = 'required|max:128';
            $rules['penduduk.*.nik'] = 'required|max:16';
            $rules['penduduk.*.nama'] = 'required|max:128';
            $rules['penduduk.*.tempat_lahir'] = 'required|max:128';
            $rules['penduduk.*.tanggal_lahir'] = 'required';
            $rules['penduduk.*.jenis_kelamin'] = 'required';
            $rules['penduduk.*.golongan_darah'] = 'required|max:3';
            $rules['penduduk.*.agama'] = 'required|max:16';
            $rules['penduduk.*.status_perkawinan'] = 'required|max:32';
            $rules['penduduk.*.status_keluarga'] = 'required';
            $rules['penduduk.*.pekerjaan'] = 'required|max:128';
            $rules['penduduk.*.keterangan'] = 'required|max:128';
            $rules['penduduk.*.id_sosial'] = 'required';
        }

        return $rules;
    }
}