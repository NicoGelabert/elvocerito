<?php

namespace App\Http\Controllers;

use App\Models\HomeHeroBanner;
use Illuminate\Http\Request;

class HomeHeroBannerController extends Controller
{
    public function index()
    {
        $homeHeroBanners = HomeHeroBanner::all();
        return $homeHeroBanners;
    }

}
