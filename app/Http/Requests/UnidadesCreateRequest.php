<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadesCreateRequest extends FormRequest
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
            'nombre_unidad' => 'required|unique:unidades,nombre_unidad',
            'abreviatura_unidad' => 'required|unique:unidades,abreviatura_unidad',
            'clasificacion_unidad',

        ];
    }
}
