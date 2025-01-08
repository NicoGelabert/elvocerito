<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends \App\Models\Service
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}