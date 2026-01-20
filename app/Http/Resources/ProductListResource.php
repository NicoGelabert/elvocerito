<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'client_number' => $this->client_number,
            'title' => $this->title,
            'slug' => $this->slug,
            'published' => $this->published,
            'urgencies' => $this->urgencies,
            'image_url' => $this->image,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
