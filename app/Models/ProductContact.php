<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'info',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
