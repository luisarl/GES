<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CnthEmpleadosUpdateRequest extends FormRequest
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
            'nombre_empleado' => 'required|unique:cnth_empleados,nombre_empleado',
            'estatus' => 'required',
            'id_departamento' => 'required|numeric|not_in:0',
        ];
    }
}
