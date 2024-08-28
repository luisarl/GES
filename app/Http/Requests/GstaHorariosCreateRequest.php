<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GstaHorariosCreateRequest extends FormRequest
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
            'id_horario',
            'nombre_horario' => 'required',
            'hora_inicio_jornada' => 'required',
            'hora_fin_jornada' => 'required|after:hora_inicio_jornada',
            'hora_inicio_descanso' => 'required|after:hora_inicio_jornada|before:hora_fin_jornada',
            'hora_fin_descanso' => 'required|after:hora_inicio_descanso|before:hora_fin_jornada',
            'dias'=>'required',
            
        ];
    }

    public function messages(): array
    {
        return[

            'nombre_horario.required'=> 'El nombre del horario es obligatorio',
            'hora_inicio_jornada.required'=> 'La hora de inicio de jornada es obligatoria',
            'hora_fin_jornada.required'=> 'La hora de fin de jornada es obligatoria',
            'hora_fin_jornada.after'=>'La hora de fin de jornada debe ser mayor a la de inicio de jornada',
            'hora_inicio_descanso.required'=> 'La hora de inicio de descanso es obligatoria',
            'hora_inicio_descanso.after'=>'La hora de inicio de descanso debe ser mayor a la de inicio de jornada',
            'hora_inicio_descanso.before'=>'La hora de inicio de descanso debe ser menor a la de fin de jornada',
            'hora_fin_descanso.required'=> 'La hora de fin de descanso es obligatoria',
            'hora_fin_descanso.after'=>'La hora de fin de descanso debe ser mayor a la de inicio de descanso',
            'hora_fin_descanso.before'=>'La hora de fin de descanso debe ser menor a la de fin de jornada',
            'dias.required'=> 'Debe seleccionar al menos un dia de la semana',
           
            
        ];
    }
}
