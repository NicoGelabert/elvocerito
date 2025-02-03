<?php

namespace App\Http\Requests;

use App\Models\Author;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'parent_id' => [
                'nullable', 'exists:authors,id',
                function(string $attribute, $value, \Closure $fail) {
                    $id = $this->get('id');
                    $author = Author::where('id', $id)->first();

                    $children = Author::getAllChildrenByParent($author);
                    $ids = array_map(fn($c) => $c->id, $children);

                    if (in_array($value, $ids)) {
                        return $fail('You cannot choose author as parent which is already a child of the author.');
                    }
                }
            ],
            'image' => ['nullable', 'image'],
            'active' => ['required', 'boolean']
        ];
    }
}
