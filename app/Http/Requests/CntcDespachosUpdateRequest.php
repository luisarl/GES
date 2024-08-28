<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CntcDespachosUpdateRequest extends FormRequest
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
        
            'motivo'=> 'required',
            'total'=> 'required|not_in:0',
        ];
    }
    public function messages(): array
    {
        return [
          
            'motivo.required' => 'Debe proporcionar un motivo para el despacho',
            'total.not_in' => 'El total de combustible debe ser mayor a 0',
        ];
    }
    

}
