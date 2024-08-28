<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CnthEntradasSalidasRequest extends FormRequest
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
                'tipo'=>'required',
                'id_almacen'=>'required|not_in:0',
                'motivo' => 'required',
                'descripcion' => 'required',
                'datosmovimiento' => 'required|min:1'
                ];
    }

    public function messages()
    {
        return [
            'datosmovimiento.required' => 'Para realizar un ajuste debe seleccionar una o varias herramientas'
        ];
    }
    
}
