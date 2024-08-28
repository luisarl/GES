<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubclasificacionesUpdateRequest extends FormRequest
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
            'nombre_subclasificacion' => 'required',
            'id_clasificacion' => 'required|not_in:0',
            'visible_fict' => 'required',
        ];
    }
}
