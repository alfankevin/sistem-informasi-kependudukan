<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKeluargaRequest extends FormRequest
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
        return [
            'no_kk' => ['required', 'string', 'max:16'],
            'alamat' => ['required', 'string', 'max:255'],
            'rt_rw' => ['required', 'string', 'max:8'],
            'kode_pos' => ['required', 'string', 'max:8'],
            'kabupaten' => ['required', 'string', 'max:50'],
            'kelurahan' => ['required', 'string', 'max:50'],
            'kecamatan' => ['required', 'string', 'max:50'],
            'provinsi' => ['required', 'string', 'max:50'],
        ];
    }
}
