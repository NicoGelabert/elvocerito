<?php

namespace App\Models\Api;

class PharmacyShift extends \App\Models\PharmacyShift
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
