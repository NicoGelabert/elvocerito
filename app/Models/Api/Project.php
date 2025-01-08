<?php

namespace App\Models\Api;

class Project extends \App\Models\Project
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
