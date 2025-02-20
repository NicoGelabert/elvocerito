<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'via',
        'via_name',
        'via_number',
        'address_unit',
        'city',
        'zip_code',
        'province',
        'link',
        'google_maps',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
