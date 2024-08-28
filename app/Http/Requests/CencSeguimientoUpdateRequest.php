<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CencSeguimientoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'fecha_horometro' => 'required_without_all:horometro_inicial_on,horometro_final_on,horometro_inicial_aut,horometro_final_aut',
            // 'horometro_inicial_on' => 'required_without_all:horometro_final_on,horometro_inicial_aut,horometro_final_aut',
            // 'horometro_final_on' => 'required_without_all:horometro_inicial_on,horometro_inicial_aut,horometro_final_aut',
            // 'horometro_inicial_aut' => 'required_without_all:horometro_final_on,horometro_inicial_on,horometro_final_aut',
            // 'horometro_final_aut' => 'required_without_all:horometro_final_on,horometro_inicial_aut,horometro_inicial_on',

        ];
    }
}
