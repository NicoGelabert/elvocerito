<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PharmacyShift extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacy_id',
        'shift_date',
        'start_time',
        'end_time',  
    ];

    protected $casts = [
        'shift_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function isOnDutyNow()
    {
        $now = Carbon::now();

        $start = Carbon::parse($this->shift_date.' '.$this->start_time);
        $end   = Carbon::parse($this->shift_date.' '.$this->end_time);

        // Turno que cruza medianoche
        if ($end->lessThan($start)) {
            $end->addDay();
        }

        return $now->between($start, $end);
    }
}
