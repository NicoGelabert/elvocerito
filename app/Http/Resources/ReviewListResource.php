<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => (float) $this->rating,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'title' => $this->title,
            'product_title' => $this->product ? $this->product->title : null,
            'published' => (bool) $this->published, 
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d'),
        ];

    }
}
