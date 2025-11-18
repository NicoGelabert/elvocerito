<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id', // Asegura que el producto exista
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|numeric|min:0|max:5', // Decimal de 0 a 5
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'token' => 'nullable|string|max:255',
            'email_verified' => 'sometimes|boolean',
            'published' => 'sometimes|boolean',
            'admin_response' => 'nullable|string',
            'created_by' => 'nullable|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
        ];
    }
}
