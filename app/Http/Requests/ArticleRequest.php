<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => ['required', 'max:2000'],
            'subtitle' => ['nullable', 'max:2000'],
            'news_lead' => ['nullable', 'max:2000'],
            'description' => ['nullable', 'string'],
            'authors.*' => ['nullable', 'int', 'exists:authors,id'],
            'images.*' => ['nullable', 'image'],
            'deleted_images.*' => ['nullable', 'int'],
            'image_positions.*' => ['nullable', 'int'],
            'published' => ['required', 'boolean'],
        ];
    }
}
