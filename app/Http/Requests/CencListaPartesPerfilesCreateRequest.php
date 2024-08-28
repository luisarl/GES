<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CencListaPartesPerfilesCreateRequest extends FormRequest
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
            'id_lperfil' => 'required',
            'id_lista_parte' => 'required',
            'id_ficha' => 'required',
            'nro_partes' => 'required',
            'cantidad_piezas' => 'required',
            'prioridad' => 'required',
            'longitud_corte' => 'required',
            'tipo_corte' => 'required',
            'id_usuario' => 'required',
            'peso_unit' => 'required',
            'peso_total' => 'required',
            'dimensiones_per' => 'required',
        ];
    }
}
