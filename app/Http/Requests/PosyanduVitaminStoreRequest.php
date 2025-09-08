<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosyanduVitaminStoreRequest extends FormRequest
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
            'posyandu_id' => ['nullable', 'integer', 'exists:posyandu,id'],
            'vitamin_id' => ['nullable', 'integer', 'exists:vitamins,id'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
