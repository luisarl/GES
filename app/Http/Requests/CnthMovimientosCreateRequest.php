<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CnthMovimientosCreateRequest extends FormRequest
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
            'motivo' => 'required',
            'estatus',
            'responsable'  => 'required|not_in:0',
            'id_almacen' => 'required|not_in:0',
            // 'id_empleado' => 'required|not_in:0',
            'id_zona' => 'required|not_in:0',
            //'cantidad_entregada' => 'required',
            //'id_herramienta' => 'required',
            'numero_solicitud'
        ];
    }
}
