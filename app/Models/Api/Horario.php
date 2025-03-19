<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends App\Models\Horario
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
