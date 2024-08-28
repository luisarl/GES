<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriasCreateRequest extends FormRequest
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
            'codigo_categoria' =>'required|unique:categorias,codigo_categoria|numeric',
            'nombre_categoria' => 'required|unique:categorias,nombre_categoria',
            'descripcion_categoria',

        ];
    }
}
