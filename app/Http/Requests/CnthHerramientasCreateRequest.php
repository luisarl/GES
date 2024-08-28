<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CnthHerramientasCreateRequest extends FormRequest
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
            'nombre_herramienta' => 'required|unique:cnth_herramientas,nombre_herramienta',
            'descripcion_herramienta' => 'required',
            'imagen_herramienta' => 'required',
            'codigo_herramienta' => 'required',
            'id_grupo' => 'required|numeric|not_in:0',
            'id_subgrupo' => 'required|numeric|not_in:0',
            'id_categoria' => 'required|numeric|not_in:0',

        ];
    }
}
