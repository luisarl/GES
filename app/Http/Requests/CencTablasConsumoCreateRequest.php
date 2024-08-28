<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CencTablasConsumoCreateRequest extends FormRequest
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
            'espesor_consumible' => 'required',
            'id_equipo',
            'id_tecnologia',
            'id_equipo_consumible',
            'valor_espesor'
        ];
    }
}
