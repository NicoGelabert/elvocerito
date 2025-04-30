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
        
        $categories = Category::with('children')->inRandomOrder()->get();

        $anunciantes_destacados = Product::where([
            ['published', '=', 1],
            ['leading_home', '=', 1]
        ])->get()->map(function ($anunciante) {
            $anunciante->first_contact = $anunciante->contacts->first(); // Guarda solo el primer contacto
            return $anunciante;
        });
        $ultimos_anunciantes = Product::where('published', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $articles = Article::with('authors', 'tags')
        ->where('published', 1)
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
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
