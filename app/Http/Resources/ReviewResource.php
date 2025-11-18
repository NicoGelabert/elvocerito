<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'product_id' => $this->product_id,
            'product_title' => $this->product ? $this->product->title : null,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'rating' => (float) $this->rating, // Aseguramos que sea decimal
            'title' => $this->title,
            'comment' => $this->comment,
            'token' => $this->token,
            'email_verified' => (bool) $this->email_verified,
            'published' => (bool) $this->published,
            'admin_response' => $this->admin_response,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        ];
    }
}
