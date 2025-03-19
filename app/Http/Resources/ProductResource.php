<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'leading_home' => (bool)$this->leading_home,
            'leading_category' => (bool)$this->leading_category,
            'urgencies' => (bool)$this->urgencies,
            'published' => (bool)$this->published,
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
            'categories' => $this->categories->map(fn($c) => $c->id),
            'image_url' => $this->image,
            'images' => $this->images,
            'contacts' => $this->contacts->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'type' => $contact->type,
                    'info' => $contact->info,
                ];
            }),
            'socials' => $this->socials->map(function ($social) {
                return [
                    'id' => $social->id,
                    'rrss' => $social->rrss,
                    'link' => $social->link,
                ];
            }),
            'addresses' => $this->addresses->map(function ($address) {
                return [
                    'id' => $address->id,
                    'title' => $address->title,
                    'via' => $address->via,
                    'via_name' => $address->via_name,
                    'via_number' => $address->via_number,
                    'address_unit' => $address->address_unit,
                    'city' => $address->city,
                    'zip_code' => $address->zip_code,
                    'province' => $address->province,
                    'link' => $address->link,
                    'google_maps' => $address->google_maps,
                ];
            }),
            'tags' => $this->tags->map(fn($t) => $t->id),
            'horarios' => $this->horarios->map(function ($horario) {
                return [
                    'id' => $horario->id,
                    'dia' => $horario->dia,
                    'apertura' => $horario->apertura,
                    'cierre' => $horario->cierre,
                ];
            }),
        ];
    }
}
