<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlmacenesUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'nombre_almacen' => 'required',
            'responsable' => 'required|regex:/^[\pL\s]+$/u',
            'correo' => 'required|email|',
            'superior' => 'required|regex:/^[\pL\s]+$/u',
            'correo2' => 'required|email|',
            'id_empresa' => 'required',
        ];
    }
}
