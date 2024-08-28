<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CencListaPartesPlanchaCreateRequest extends FormRequest
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
            'id_lplancha'     => 'required',
            'id_lista_parte'  => 'required',
            'nro_partes'      => 'required',
            'descripcion'     => 'required',
            'prioridad'       => 'required',
            'dimensiones'     => 'required',
            'espesor'         => 'required',
            'cantidad_piezas' => 'required',
            'id_usuario'      => 'required'
        ];
    }
}
