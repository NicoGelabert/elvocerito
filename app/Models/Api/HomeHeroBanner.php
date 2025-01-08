<?php

namespace App\Models\Api;

class HomeHeroBanner extends \App\Models\HomeHeroBanner
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
