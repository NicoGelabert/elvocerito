<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HorarioResource extends JsonResource
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
            'id' => $this->id,
            'product_id' => $this->product_id,
            'dia' => $this->dia,
            'apertura' => $this->apertura ?? 'CERRADO', // Si es NULL, muestra "CERRADO"
            'cierre' => $this->cierre ?? 'CERRADO',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'), // Formato más limpio
        ];
    }
}
