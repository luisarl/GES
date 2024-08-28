<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CnttControlTonerCreateRequest extends FormRequest
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
            'fecha_cambio' => 'required|after:fecha_ultimo_cambio',
            'departamento'=> 'required',
            'activo'=> 'required',
            'fecha_ultimo_cambio'=> 'required|before:fecha_cambio',
            'cantidad_anterior'=> 'required|gt:0',
            'cantidad_actual'=> 'required|gt:cantidad_anterior',
            'servicio'=> 'required',
            'cantidad_total'=> 'required|gt:0',
            'dias_total'=> 'required|gt:0',
        ];
    }
    
    public function messages(): array
    {
        return [
            'fecha_cambio.after' => 'La fecha del cambio debe ser posterior a la del último cambio',
            'fecha_ultimo_cambio.before' => 'La fecha de último cambio debe ser anterior a la actual',
            'fecha_cambio.required' => 'Debe seleccionar una fecha de cambio',
            'fecha_ultimo_cambio.required' => 'Debe seleccionar una fecha de último cambio',
            'departamento.required' => 'Debe seleccionar un Departamento',
            'activo.required' => 'Debe Seleccionar una Impresora',
            'cantidad_actual.required' => 'Debe ingresar el valor del contador actual',
            'cantidad_anterior.required' => 'Debe ingresar el valor del contador anterior',
            'servicio.required' => 'Debe seleccionar un tipo de servicio',
            'cantidad_total.gt' => 'El total de Hojas impresas debe ser mayor a 0',
            'dias_total.gt' => 'El total de Días de duración debe ser mayor a 0',
            'cantidad_actual.gt' => 'El valor del contador actual debe ser mayor al contador anterior',
            'cantidad_anterior.gt' => 'El valor del contador anterior debe ser mayor a 0',
        ];
    }
}
