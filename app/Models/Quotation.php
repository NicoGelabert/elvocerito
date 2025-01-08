<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    public $fillable = ['name', 'email', 'phone', 'tags', 'message'];

    protected $casts = [
        'tags' => 'array', // Esto permite que Laravel maneje `tags` como un array
    ];
}
