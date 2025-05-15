<?php

namespace App\Http\Controllers;

use App\Models\HomeHeroBanner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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

        $viewedProductsIds = json_decode(Cookie::get('recently_viewed'), true) ?? [];
        if (count($viewedProductsIds) > 0) {
            $viewedProducts = Product::whereIn('id', $viewedProductsIds)
                                    ->orderByRaw('FIELD(id, ' . implode(',', $viewedProductsIds) . ')')
                                    ->get();
        } else {
            // Si no hay productos vistos, devolvé una colección vacía para evitar errores en la vista
            $viewedProducts = collect();
        }
        return view('welcome', compact(
            'homeherobanners',
            'categories',
            'anunciantes_destacados',
            'ultimos_anunciantes',
            'articles',
            'viewedProducts'
        ));
    }

}
