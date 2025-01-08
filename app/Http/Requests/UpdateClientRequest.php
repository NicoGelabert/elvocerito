<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
                'nullable', 'exists:clients,id',
                function(string $attribute, $value, \Closure $fail) {
                    $id = $this->get('id');
                    $client = Client::where('id', $id)->first();

                    $children = Client::getAllChildrenByParent($client);
                    $ids = array_map(fn($c) => $c->id, $children);

                    if (in_array($value, $ids)) {
                        return $fail('You cannot choose client as parent which is already a child of the client.');
                    }
                }
            ],
            'image' => ['nullable', 'image'],
            'active' => ['required', 'boolean']
        ];
    }
}
