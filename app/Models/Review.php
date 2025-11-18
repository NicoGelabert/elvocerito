<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'last_name',
        'email',
        'rating',
        'title',
        'comment',
        'token',
        'email_verified',
        'published',
        'admin_response',
        'created_by',
        'updated_by',
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
