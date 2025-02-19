<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSocial extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'rrss',
        'link',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
