<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PharmacyShiftResource extends JsonResource
{
    
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'pharmacy_id' => $this->pharmacy_id,
            'shift_date'  => $this->shift_date->format('Y-m-d'),
            'start_time'  => $this->start_time,
            'end_time'    => $this->end_time,
            'title'       => "Farmacia #{$this->pharmacy_id}",
            'created_at'  => $this->created_at->format('Y-m-d H:i'),
            'updated_at'  => $this->updated_at->format('Y-m-d H:i'),
        ];
    }
}
