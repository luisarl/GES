<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolsServiciosCreateRequest extends FormRequest
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
            'id_departamento' => 'required|not_in:0',
            'nombre_servicio' => 'required',
            'descripcion_servicio',
        ];
    }
}
