<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmbaParametrosCreateRequest extends FormRequest
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
            'nombre_parametro' => 'required|unique:emba_parametros,nombre_parametro',
            'id_unidad' => 'required|not_in:0',
            'descripcion_parametro'
        ];
    }
}
