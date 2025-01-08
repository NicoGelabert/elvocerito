<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'active' => ['required', 'boolean'],
            'short_description' => ['required', 'string'],
            'description' => ['required', 'string'],
            'attributes' => ['required', 'array'],
            'attributes.*.text' => ['required', 'string', 'min:0.01'],
            'image' => ['required', 'image'],
            'parent_id' => ['nullable', 'exists:categories,id'],
        ];
    }
}
