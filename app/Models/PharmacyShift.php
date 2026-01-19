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
        'created_by',
        'updated_by'  
    ];

    protected $casts = [
        'shift_date' => 'date',
        'start_time' => 'string',
        'end_time'   => 'string',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function isOnDutyNow()
    {
        $now = \Carbon\Carbon::now();

        $date = $this->shift_date->format('Y-m-d');

        // Tomar solo la hora en caso de que venga con fecha incluida
        $startHour = substr($this->start_time, -8); // HH:MM:SS
        $endHour   = substr($this->end_time, -8);

        $start = \Carbon\Carbon::parse("$date $startHour");
        $end   = \Carbon\Carbon::parse("$date $endHour");

        // Turno que cruza medianoche
        if ($end->lessThan($start)) {
            $end->addDay();
        }

        return $now->between($start, $end);
    }
}
