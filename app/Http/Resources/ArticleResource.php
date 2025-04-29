<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ArticleResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'subtitle' => $this->subtitle,
            'news_lead' => $this->news_lead,
            'description' => $this->description,
            'published' => (bool)$this->published,
            'image_url' => $this->image,
            'images' => $this->images,
            'authors' => $this->authors->map(fn($a) => $a->id),
            'tags' => $this->tags->map(fn($t) => $t->id),
            'items' => $this->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'texto' => $item->texto,
                ];
            }),
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
