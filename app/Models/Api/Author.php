<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Author extends \App\Models\Author
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
