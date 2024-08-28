<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaisesUpdateRequest extends FormRequest
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
            'nombre_pais' => 'required',
            'id_pais' => 'required',
        ];
    }
}
