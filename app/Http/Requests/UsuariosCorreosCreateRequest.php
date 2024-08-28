<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosCorreosCreateRequest extends FormRequest
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
            'proceso' => 'required|not_in:0',
            'correo_destinatario' => 'required|email',
            'nombre_destinatario' => 'required',
            'id_usuario' => 'required|not_in:0'
        ];
    }
}
