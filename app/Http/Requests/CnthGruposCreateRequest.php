<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CnthGruposCreateRequest extends FormRequest
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
            'codigo_grupo' => 'required|numeric|unique:cnth_grupos,codigo_grupo',
            'nombre_grupo' => 'required',
            'descripcion_grupo' ,
        ];
    }
}
