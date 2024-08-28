<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AudiAuditoriaInventarioCreateRequest extends FormRequest
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
            'id_articulo' => 'required',
            'codigo_articulo' => 'required',
            'id_almacen' => 'required|not_in:0',
            //'id_subalmacen' => 'required|not_in:0',
            //'stock_actual' => 'required',
            //'conteo_fisico' => 'required',
            'numero_auditoria' => 'required'
        ];
    }
}
