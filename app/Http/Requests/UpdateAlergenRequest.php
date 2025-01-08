<?php

namespace App\Http\Requests;

use App\Models\Alergen;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAlergenRequest extends FormRequest
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
            'parent_id' => [
                'nullable', 'exists:alergens,id',
                function(string $attribute, $value, \Closure $fail) {
                    $id = $this->get('id');
                    $alergen = Alergen::where('id', $id)->first();

                    $children = Alergen::getAllChildrenByParent($alergen);
                    $ids = array_map(fn($c) => $c->id, $children);

                    if (in_array($value, $ids)) {
                        return $fail('You cannot choose alergen as parent which is already a child of the alergen.');
                    }
                }
            ],
            'image' => ['nullable', 'image'],
            'active' => ['required', 'boolean']
        ];
    }
}
