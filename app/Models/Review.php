<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'last_name',
        'email',
        'rating',
        'comment',
        'token',
        'email_verified',
        'published',
        'admin_response',
    ];

    protected $casts = [
        'email_verified' => 'boolean',
        'published' => 'boolean',
        'rating' => 'decimal:1',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
