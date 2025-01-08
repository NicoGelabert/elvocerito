<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'title' => ['required', 'max:2000'],
            'services.*' => ['nullable', 'int', 'exists:services,id'],
            'tags.*' => ['nullable', 'int', 'exists:tags,id'],
            'clients.*' => ['nullable', 'int', 'exists:clients,id'],
            'description' => ['nullable', 'string'],
            'images.*' => ['nullable', 'image'],
            'deleted_images.*' => ['nullable', 'int'],
            'image_positions.*' => ['nullable', 'int'],
            'published' => ['required', 'boolean']
        ];
    }
}
