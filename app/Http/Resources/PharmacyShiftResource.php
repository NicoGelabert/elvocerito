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
        $date = $this->shift_date->format('Y-m-d');
        $start = \Carbon\Carbon::parse("$date {$this->start_time}");
        $end   = \Carbon\Carbon::parse("$date {$this->end_time}");
        
        if ($end->lessThan($start)) {
            $end->addDay();
        }
        
        return [
            'id'          => $this->id,
            'pharmacy_id' => $this->pharmacy_id,
            'shift_date'  => $this->shift_date->format('Y-m-d'),
            'start_time'  => $this->start_time,
            'end_time'    => $this->end_time,
            'end_datetime' => $end->format('Y-m-d H:i'),        // para lógica
            'end_label'    => $end->isoFormat('dddd D [de] MMMM, H:mm'), // para mostrar
            'title'       => "Farmacia #{$this->pharmacy_id}",
            'created_at'  => $this->created_at->format('Y-m-d H:i'),
            'updated_at'  => $this->updated_at->format('Y-m-d H:i'),
        ];
    }
}
