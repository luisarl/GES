<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FictSubalmacenesCreateRequest extends FormRequest
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
            'nombre_subalmacen' => 'required',
            'descripcion_subalmacen' => 'required',
            'codigo_subalmacen' => 'required|unique:subalmacenes,codigo_subalmacen',
            'id_almacen' => 'required|exists:almacenes,id_almacen'
        ];
    }
}


