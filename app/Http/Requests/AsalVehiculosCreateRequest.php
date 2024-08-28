<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsalVehiculosCreateRequest extends FormRequest
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

            'activo' => 'required',
            'placa_vehiculo' => 'required|unique:Asal_Vehiculos,placa_vehiculo',
            'marca_vehiculo' => 'required',
            'modelo_vehiculo' => 'required',
            'descripcion',
        ];
    }
}
