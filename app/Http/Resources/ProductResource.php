<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = false;

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
            'client_number' => $this->client_number,
            'published' => (bool)$this->published,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),

            'categories' => $this->categories->sortBy('id')->values(),

            'image_url' => $this->images->first()->url ?? 'storage/common/noimage.png',
            'images' => $this->images,

            'contacts' => $this->contacts->map(fn($c) => [
                'id' => $c->id,
                'type' => $c->type,
                'info' => $c->info,
            ]),

            'socials' => $this->socials->map(fn($s) => [
                'id' => $s->id,
                'type' => $s->rrss,
                'info' => $s->link,
            ]),

            'horarios' => $this->horarios->map(fn($h) => [
                'dia' => mb_strtolower($h->dia),
                'apertura' => substr($h->apertura, 0, 5), // HH:MM
                'cierre' => substr($h->cierre, 0, 5),
            ])->values(),

            'pharmacy_shifts' => $this->when($this->pharmacy, function () {
                return $this->pharmacy->shifts->map(fn($shift) => [
                    'id'         => $shift->id,
                    'shift_date' => $shift->shift_date->format('Y-m-d'),
                    'start_time' => substr($shift->start_time, 0, 5), // HH:MM
                    'end_time'   => substr($shift->end_time, 0, 5),
                ]);
            }),

            'is_on_duty_now' => $this->pharmacy
                ? $this->pharmacy->shifts->contains(fn($shift) => $shift->isOnDutyNow())
                : false,
        ];
    }
}
