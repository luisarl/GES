<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubgruposCreateRequest extends FormRequest
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
            'nombre_subgrupo' => 'required',
            'descripcion_subgrupo',
            'codigo_subgrupo' => 'required|numeric|unique:subgrupos,codigo_subgrupo',
            'id_grupo' => 'required|not_in:0'
        ];
    }
}
