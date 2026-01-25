<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Faq extends App\Models\Faq
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
