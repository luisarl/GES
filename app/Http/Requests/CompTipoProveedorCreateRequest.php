<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompTipoProveedorCreateRequest extends FormRequest
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
            'id_tipo' => 'required|unique:comp_tipo_proveedor,id_tipo',
            'nombre_tipo' => 'required|unique:comp_tipo_proveedor,nombre_tipo',
        ];
    }
}
