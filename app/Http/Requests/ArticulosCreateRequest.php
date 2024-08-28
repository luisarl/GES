<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticulosCreateRequest extends FormRequest
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
     */
    public function rules()
    {
        return [
            //'codigo_articulo' => 'excludeIf:codigo_articulo,==,NULL|unique:articulos,codigo_articulo',
            'correlativo',
            'nombre_articulo' => 'required|unique:articulos,nombre_articulo',
            'descripcion_articulo' => 'required',
            'imagen_articulo' =>'required',
            'referencia' => 'max:20',
            'documento_articulo' =>'mimes:pdf',
            'pntominimo_articulo' => 'required',
            'pntomaximo_articulo' => 'required',
            'pntopedido_articulo' => 'required',
            'equi_unid_pri' =>'numeric|excludeIf:tipo_unidad,==,SIMPLE|between:1,1',
            'equi_unid_sec'=>'numeric|excludeIf:tipo_unidad,==,SIMPLE|gt:0',
            'equi_unid_ter' =>'numeric|excludeIf:tipo_unidad,==,SIMPLE|gt:0',
            'tipo_unidad' => 'required',
            'id_tipo' => 'required|not_in:0',
            'id_grupo' => 'required|numeric|not_in:0',
            'id_subgrupo' => 'required|numeric|not_in:0',
            'id_categoria' => 'required|numeric|not_in:0',
            'id_unidad' => 'required|numeric|not_in:0|excludeIf:tipo_unidad,==,SIMPLE|different:id_unidad_sec',
            'id_unidad_sec' => 'required|not_in:0|excludeIf:tipo_unidad,==,SIMPLE|different:id_unidad_ter',
            'id_unidad_ter'=>'excludeIf:tipo_unidad,==,SIMPLE|different:id_unidad|not_in:0',
            'empresas' => 'required',
            'estatus'
        ];
    }

    public function messages()
    {
        return [
            'empresas.required' => 'Para crear un articulo debe seleccionar una o varios empresas'
        ];
    }
}
