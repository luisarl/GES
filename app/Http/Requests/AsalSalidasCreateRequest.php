<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsalSalidasCreateRequest extends FormRequest
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
            'destino' => 'required',
            'motivo' => 'required',
            'solicitante' => 'required|not_in:0',
            'departamento' => 'required',
            'correlativo',
            'autorizado' => 'required|not_in:0',
            'responsable' => 'required|not_in:0',
            'tipo_chofer' => 'required',
            'conductorinterno' => 'excludeIf:tipo_chofer,==,FORANEO|required|not_in:0',
            'conductorforaneo' => 'excludeIf:tipo_chofer,==,INTERNO|required|regex:/^[\pL\s]+$/u|min:5',
            'tipo_vehiculo' => 'required',
            'id_vehiculo' => 'excludeIf:tipo_vehiculo,==,FORANEO|required|not_in:0',
            'placa' => 'excludeIf:tipo_vehiculo,==,INTERNO|required|min:4',
            'marca' => 'excludeIf:tipo_vehiculo,==,INTERNO|required|min:3',
            'modelo' => 'excludeIf:tipo_vehiculo,==,INTERNO|required|min:2',
            'fecha_salida' => 'required|after_or_equal:'.date("Y-m-d"),
            'hora_salida'=> 'required|exclude_unless:fecha_salida,==,'.date("Y-m-d").'|after:'.date('H:i'),
            'id_almacen' => 'required|not_in:0',    
            'id_tipo' => 'required|not_in:0',
            'id_subtipo' => 'required|not_in:0',
        ];
    }

    public function messages()
    {
        return [
            'hora_salida.after' => 'El campo hora salida debe ser una hora posterior a '.date('h:i A')
        ];
    }
}
