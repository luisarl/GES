<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticulosMigrateRequest extends FormRequest
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
            'id_articulo' => 'required',
            'empresas' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'empresas.required' => 'Para enviar un articulo a PROFIT debe seleccionar una o varias empresas'
        ];
    }



}
