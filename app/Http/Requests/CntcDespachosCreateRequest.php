<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CntcDespachosCreateRequest extends FormRequest
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
            'departamento'=> 'required',
            'motivo'=> 'required',
            'total'=> 'required|not_in:0',
 
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'id_combustible.required' => 'Debe seleccionar un tipo de Combustible',
            'departamento.required' => 'Debe seleccionar un Departamento',
            'motivo.required' => 'Debe proporcionar un motivo para el despacho',
            'total.not_in' => 'El total de combustible debe ser mayor a 0',
        ];
    }
}