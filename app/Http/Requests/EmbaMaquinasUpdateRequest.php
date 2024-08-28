<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmbaMaquinasUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_embarcacion'=>'required',
            'nombre_maquina' => 'required',
            'descripcion_maquina',
        ];
    }

    public function messages(): array
    {
        return[

            'id_embarcacion.required'=> 'Debe seleccionar una embarcacion',
            'nombre_maquina.required'=> 'Debe ingresar un nombre a la maquina',
           
            
        ];
    }
}
