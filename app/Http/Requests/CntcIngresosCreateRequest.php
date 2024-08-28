<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CntcIngresosCreateRequest extends FormRequest
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
            'id_combustible' => 'required',
            'id_tipo_ingreso'=>'required',
            'cantidad'=> 'required|not_in:0',
            'stock'=> 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'id_combustible.required' => 'Debe seleccionar un tipo de Combustible',
            'id_tipo_ingreso.required' => 'Debe seleccionar un tipo de Ingreso',
            'cantidad.not_in' => 'El total del combustible a ingresar debe ser mayor a 0',
            'cantidad.required' => 'Debe Ingresar una cantidad de combustible',
        ];
    }
}
