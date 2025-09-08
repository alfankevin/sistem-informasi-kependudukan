<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosyanduVaksinUpdateRequest extends FormRequest
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
            'posyandu_id' => ['nullable', 'integer', 'exists:posyandus,id'],
            'vaksin_id' => ['nullable', 'integer', 'exists:vaksins,id'],
            'dosis_ke' => ['nullable', 'integer'],
        ];
    }
}
