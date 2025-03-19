<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHorario extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'dia',
        'apertura',
        'cierre'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
