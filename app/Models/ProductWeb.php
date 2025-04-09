<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWeb extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'webpage',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
