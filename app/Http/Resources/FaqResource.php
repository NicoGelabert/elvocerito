<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    public static $wrap = false;

    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'category' => $this->category,
            'question' => $this->question,
            'answer' => $this->answer,
            'published' => (bool)$this->published,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
