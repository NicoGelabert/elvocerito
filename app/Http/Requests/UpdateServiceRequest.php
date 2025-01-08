<?php

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'image' => ['nullable', 'image'],
            'parent_id' => [
                'nullable', 'exists:services,id',
                function(string $attribute, $value, \Closure $fail) {
                    $id = $this->get('id');
                    $service = Service::where('id', $id)->first();

                    $children = Service::getAllChildrenByParent($service);
                    $ids = array_map(fn($c) => $c->id, $children);

                    if (in_array($value, $ids)) {
                        return $fail('You cannot choose service as parent which is already a child of the service.');
                    }
                }
            ],
        ];
    }
}
