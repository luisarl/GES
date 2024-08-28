<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FictUbicacionesUpdateRequest extends FormRequest
{
    /**
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
            'id_articulo' => 'required|numeric',
            'id_almacen' => 'required|numeric',
            'id_subalmacen' => 'required|numeric',
            'ubicacion' => 'required|string|max:255',
        ];
    }
}
