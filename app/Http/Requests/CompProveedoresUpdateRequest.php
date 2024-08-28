<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompProveedoresUpdateRequest extends FormRequest
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
            //'id_proveedor',
            'codigo_proveedor' => 'required',
            'nombre_proveedor' => 'required',
            'nit', 
            'rif' => 'required|min:12|max:12|not_regex:/_/',
            'correo' => 'required|email',
            'activo',
            'direccion' => 'required',
            'responsable' => 'required',
            'nacional',
            'ciudad',
            'codigo_postal',
            'telefonos' => 'required',
            'website' => '',
            'ruc',
            'lae',
            'pago1',
            'pago2',
            'pago3',
            'pago4',
            'codigo_actividad',
            'tipo_persona' => 'required|not_in:0',
            'cont_especial',
            'porc_retencion',
            'comentario',
            'creado_por',
            'actualizado_por',
            'id_tipo' => 'required|not_in:NO',
            'id_segmento' => 'required|not_in:NO',
            'id_zona' => 'required|not_in:NO',
            'id_pais' => 'required|not_in:NO',
        ];
    }
}
