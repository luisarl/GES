<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GstaEmpleadosUpdateRequest extends FormRequest
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
            'id_horario' => 'required|numeric',
        ];
    }
    public function messages(): array
    {
        return[

            'id_horario.required'=> 'Debe Seleccionar Un Horario',
            'id_horario.numeric'=> 'Debe Seleccionar Un Horario',
        ];
    }
}
