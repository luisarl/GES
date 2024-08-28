<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CntcTiposCombustiblesCreateRequest extends FormRequest
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
            'combustible'=>'required',
            'departamento'=>'required',
            'stock'=>'required|not_in:0',
        ];
    }
    public function messages(): array
    {
        return [
            'combustible.required' => 'Debe ingresar un nombre para el tipo de combustible',
            'departamento.required' => 'Debe ingresar un departamento encargado del combustible',
            'stock.required' => 'Debe ingresar un stock inicial de combustible',
            'stock.not_in' => 'Debe ingresar un stock inicial mayor a 0',
        ];
    }
}
