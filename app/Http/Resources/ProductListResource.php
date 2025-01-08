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
            'title' => $this->title,
            'slug' => $this->slug,
            'image_url' => $this->image,
            'quantity' => $this->quantity,
            'updated_at' => ( new \DateTime($this->updated_at) )->format('Y-m-d H:i:s'),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'prices' => ProductPriceResource::collection($this->whenLoaded('prices')),
            'alergens' => ProductAlergenResource::collection($this->whenLoaded('alergens')),
        ];
    }
}
