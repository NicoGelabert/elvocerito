<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeHeroBannerRequest extends FormRequest
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
            'image' => ['nullable', 'image'],
            'headline' => ['required', 'max:200'],
            'description' => ['nullable', 'string'],
            'link' => ['nullable', 'string'],
            'title' => ['nullable', 'string'],
            'service' => ['nullable', 'string']
        ];
    }
}
