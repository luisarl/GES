<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResgSolicitudesResguardoCreateRequest extends FormRequest
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
            'id_almacen' => 'required|not_in:0',
            'ubicacion_actual' => 'required',
            'responsable' => 'required|not_in:0',
            'observacion' => 'required'

        ];
    }
}
