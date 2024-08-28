<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CnthHerramientasUpdateRequest extends FormRequest
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
            'nombre_herramienta' => 'required',
            'descripcion_herramienta' => 'required',
            'codigo_herramienta' => 'required',
            'correlativo',
            'id_categoria' => 'required',
        ];
    }
}
