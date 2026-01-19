<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = ['product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function shifts()
    {
        return $this->hasMany(PharmacyShift::class);
    }

    public function isOnDutyNow(): bool
    {
        foreach ($this->shifts as $shift) {
            if ($shift->isOnDutyNow()) {
                return true;
            }
        }

        return false;
    }
}
