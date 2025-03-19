<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HorarioRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'dia' => 'required|in:lunes,martes,miércoles,jueves,viernes,sábado,domingo', 
            'apertura' => 'nullable|date_format:H:i', 
            'cierre' => 'nullable|date_format:H:i|after:apertura', 
        ];
    }
}
