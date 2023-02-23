<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorepisosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        // Se pueden poner distintas reglas con condicionales dependiendo del metodo
        // if ($this->isMethod('PATCH')){
        //     return [
        //         //
        //     ];
        // }
        return [
            'titulo' => ['required'],
            'ciudad' => ['required'],
            'zona' => ['required'],
            'precio' => ['required'],
            'planta' => ['required'],
            'extension' => ['required'],
            'habitaciones' => ['required'],
            'baños' => ['required'],
            'descripcion' => ['required'],
            'ciudad' => ['required'],
            'propietario' => ['required'],
            'image_path' => []
        ];
    }
}