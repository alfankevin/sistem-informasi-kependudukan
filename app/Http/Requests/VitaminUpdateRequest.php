<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VitaminUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nama_vitamin' => ['required', 'string', 'max:100'],
            'deskripsi' => ['required', 'string'],
            'usia_pemberian' => ['required', 'string', 'max:50'],
            'dosis' => ['required', 'string', 'max:50'],
        ];
    }
}
