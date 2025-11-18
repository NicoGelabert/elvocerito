<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends \App\Models\Review
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
