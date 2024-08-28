<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompZonasCreateRequest extends FormRequest
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
            'id_zona' => 'required|alpha|unique:comp_zonas,id_zona',
            'nombre_zona' => 'required|unique:comp_zonas,nombre_zona',
        ];
    }
}
