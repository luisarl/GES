<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticulosUbicacionCreateRequest extends FormRequest
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
            'id_almacen' => 'required|numeric|not_in:0',
            'id_subalmacen' =>'required|numeric|not_in:0',
            'id_ubicacion' => 'required|numeric|not_in:0',
            //'ubicacion' => 'required|string|max:255',
        ];
    }
}
