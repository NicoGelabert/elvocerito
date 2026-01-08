<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyShift extends Model
{
    use HasFactory;

    protected $fillable = ['pharmacy_id', 'shift_date'];

    protected $casts = [
        'shift_date' => 'date',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
