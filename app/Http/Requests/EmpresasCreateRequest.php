<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresasCreateRequest extends FormRequest
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

        'nombre_empresa' => 'required|unique:empresas,nombre_empresa',
        'presidente' => 'required',
        'correo_presidente'=> 'required',
        'base_datos'=> 'required|unique:empresas,base_datos',
        'alias_empresa'=> 'required',
        'responsable_almacen' => 'required',
        'correo_responsable' => 'required',
        'superior_almacen' => 'required',
        'correo_superior' => 'required',
        'visible_ficht'

        ];
    }
}
