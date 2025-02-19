<?php

namespace App\Http\Controllers;

use App\Models\HomeHeroBanner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Article;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $homeherobanners = HomeHeroBanner::all();
        $categories = Category::all();
        $anunciantes_destacados = Product::where('leading_home', 1)->get();
        $ultimos_anunciantes = Product::all();
        $articles = Article::all();
        // $features = Feature::all();
        // $services = Service::all();
        // $tags = Tag::all();
        // $clients = Client::all();
        // $projects = Project::with('tags', 'clients')->whereHas('services', function($query) {
        //     $query->where('service_id', 2);
        // })->get();
        // $devprojects = Project::with('tags', 'clients')->whereHas('services', function($query) {
        //     $query->where('service_id', 1);
        // })->get();
        // $faqs = Faq::all();
        return view('welcome', compact(
            'homeherobanners',
            'categories',
            'anunciantes_destacados',
            'ultimos_anunciantes',
            'articles',
            // 'features',
            // 'services',
            // 'tags',
            // 'clients',
            // 'projects',
            // 'devprojects',
            // 'faqs'
        )
    );
    }
}
