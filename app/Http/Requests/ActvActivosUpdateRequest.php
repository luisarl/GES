<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActvActivosUpdateRequest extends FormRequest
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
            'id_activo',
            'codigo_activo' => 'required',
            'nombre_activo' => 'required',
            'descripcion_activo',
            'imagen_activo',
            'marca',
            'modelo',
            'serial',
            'ubicacion',
            'id_tipo' => 'required|not_in:0',
            'id_departamento' => 'required|not_in:0',
            'id_subtipo' => 'required|not_in:0',
        ];
    }
}
