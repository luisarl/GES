<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolsSolicitudesCreateRequest extends FormRequest
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
            'id_departamento_servicio' => 'required|not_in:0',
            'asunto_solicitud' => 'required',
            'descripcion_solicitud' =>  'required',
            'id_servicio' => 'required|not_in:0',
            'id_subservicio' => 'required|not_in:0',
            'prioridad' => 'required|not_in:0',
            'logistica_origen' => 'exclude_unless:id_departamento_servicio,==,9|required',
            'logistica_destino' => 'exclude_unless:id_departamento_servicio,==,9|required',
            'logistica_fecha' => 'exclude_unless:id_departamento_servicio,==,9|required',
            'logistica_telefono' => 'exclude_unless:id_departamento_servicio,==,9|required|min:11|numeric',
            'mantenimiento_tipo_equipo' => 'exclude_unless:id_departamento_servicio,==,10,22|required|not_in:0',
            'mantenimiento_nombre_equipo' => 'exclude_unless:id_departamento_servicio,==,10,22|required',
            'mantenimiento_codigo_equipo' => 'exclude_unless:id_departamento_servicio,==,10|required',
        ];
    }
}
