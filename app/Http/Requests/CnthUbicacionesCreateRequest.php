<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CnthUbicacionesCreateRequest extends FormRequest
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
            'codigo_ubicacion' => 'required',
            'nombre_ubicacion' => 'required',
            'id_almacen' => 'required|numeric|not_in:0',
        ];
    }
}
