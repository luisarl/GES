<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CntcTiposIngresosCreateRequest extends FormRequest
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
            'descripcion'=>'required',
        ];
    }
    public function messages(): array
    {
        return [
            'descripcion.required' => 'Debe ingresar un nombre para el tipo de ingreso',
        ];
    }
}
