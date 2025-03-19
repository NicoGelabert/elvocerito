<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:2000'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'leading_home' => ['required', 'boolean'],
            'leading_category' => ['required', 'boolean'],
            'urgencies' => ['required', 'boolean'],
            'published' => ['required', 'boolean'],
            'categories.*' => ['nullable', 'int', 'exists:categories,id'],
            'images.*' => ['nullable', 'image'],
            'deleted_images.*' => ['nullable', 'int'],
            'image_positions.*' => ['nullable', 'int'],
            'contacts' => ['nullable', 'array'],
            'contacts.*.type' => ['nullable', 'string', 'max:200'],
            'contacts.*.info' => ['nullable', 'string', 'max:200'],
            'socials' => ['nullable', 'array'],
            'socials.*.rrss' => ['nullable', 'string', 'max:200'],
            'socials.*.link' => ['nullable', 'string', 'max:200'],
            'addresses' => ['nullable', 'array'],
            'addresses.*.title' => ['nullable', 'string', 'max:100'],
            'addresses.*.via' => ['nullable', 'string', 'max:50'],
            'addresses.*.via_name' => ['nullable', 'string', 'max:100'],
            'addresses.*.via_number' => ['nullable', 'int'],
            'addresses.*.address_unit' => ['nullable', 'string', 'max:20'],
            'addresses.*.city' => ['nullable', 'string', 'max:100'],
            'addresses.*.zip_code' => ['nullable', 'string', 'max:20'],
            'addresses.*.province' => ['nullable', 'string', 'max:50'],
            'addresses.*.link' => ['nullable', 'string', 'max:500'],
            'addresses.*.google_maps' => ['nullable', 'string', 'max:1000'],
            'tags.*' => ['nullable', 'int', 'exists:tags,id'],
            'horarios' => ['nullable', 'array'],
            'horarios.*.dia' => ['required', 'in:lunes,martes,miércoles,jueves,viernes,sábado,domingo'],
            'horarios.*.apertura' => ['nullable'], 
            'horarios.*.cierre' => ['nullable', 'after:horarios.*.apertura'], // Debe ser después de apertura
        ];
    }
}
