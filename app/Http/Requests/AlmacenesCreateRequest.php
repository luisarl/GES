<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlmacenesCreateRequest extends FormRequest
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


    public function rules()
    {
        return [
            'nombre_almacen' => 'required|unique:almacenes,nombre_almacen',
            'responsable' => 'required|regex:/^[\pL\s]+$/u',
            'correo' => 'required|email|',
            'superior' => 'required|regex:/^[\pL\s]+$/u',
            'correo2' => 'required|email|',
            'id_empresa' => 'required',
            'visible_ficht',
            'visible_cnth',
        ];
    }
}
 