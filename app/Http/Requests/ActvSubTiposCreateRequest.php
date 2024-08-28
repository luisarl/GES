<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActvSubTiposCreateRequest extends FormRequest
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
            'id_subtipo',
            'nombre_subtipo' => 'required|unique:actv_subtipos,nombre_subtipo',
            'id_tipo' =>'required|not_in:0'
        ];
    }
}
