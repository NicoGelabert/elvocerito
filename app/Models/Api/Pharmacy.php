<?php

namespace App\Models\Api;

class Pharmacy extends \App\Models\Pharmacy

{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
