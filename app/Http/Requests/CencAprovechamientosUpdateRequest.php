<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CencAprovechamientosUpdateRequest extends FormRequest
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
            'id_conap'=> 'required|not_in:0',
            'id_listaparte'=> 'required|not_in:0',
            'espesor'=> 'required|not_in:0',
            'equipocorte'=> 'required|not_in:0',
            'tecnologia'=> 'required|not_in:0',
            /// LISTO (tecnologia = PLASMA) (equipocorte = KF2612) (boquilla 1,2,3...)
            'boquilla'=> 'excludeIf:tecnologia,==,2|excludeIf:equipocorte,==,1|required|not_in:0',
            /// LISTO (tecnologia = PLASMA) (equipocorte = MORROCOY) (boquilla QUEMADOR)
            'boquilla2'=> 'excludeIf:tecnologia,==,2|excludeIf:equipocorte,==,2|required|not_in:0',
            /// LISTO (tecnologia = OXICORTE) (equipocorte = MORROCOY) (boquilla QUEMADOR)
            'antorcha'=> 'excludeIf:tecnologia,==,1|excludeIf:equipocorte,==,2|required|not_in:0',

            'precalentamiento' => 'excludeIf:tecnologia,==,2|required|not_in:0',
            'tiempo_precalentamiento'=> 'excludeIf:tecnologia,==,2|required|not_in:0', 
            'longitud_corte'=> 'required|not_in:01|numeric',
            'numero_piercing'=> 'required|not_in:0|numeric',
            'tiempo_estimado_corte'=> 'required|not_in:0',
            //'_caracteristicas' => 'required|not_in:0'
        ];
    }
}
