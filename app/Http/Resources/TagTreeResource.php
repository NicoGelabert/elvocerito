<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class TagTreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
            'label' => $this->name,
            'children' => [],
        ];

        if ($this->children && $this->children->isNotEmpty()) {
            $data['children'] = TagTreeResource::collection(
                $this->children->sortBy('name')->values()
            );
        }

        return $data;
    }


}
