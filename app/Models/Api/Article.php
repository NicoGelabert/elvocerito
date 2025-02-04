<?php

namespace App\Models\Api;

class Article extends \App\Models\Article
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
