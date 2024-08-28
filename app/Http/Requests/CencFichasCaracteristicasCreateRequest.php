<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CencFichasCaracteristicasCreateRequest extends FormRequest
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
            'id_caracteristica',
            'nombre_caracteristica' => 'required|unique:actv_caracteristicas,nombre_caracteristica',
            'id_tipo' => 'required|not_in:0'
        ];
    }
}
