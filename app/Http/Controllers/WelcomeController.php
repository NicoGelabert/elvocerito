<?php

namespace App\Http\Controllers;

use App\Models\HomeHeroBanner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WelcomeController extends Controller
{
    public function index()
    {
        $homeherobanners = HomeHeroBanner::all();
        
        $categories = Category::with('children')
        ->whereHas('products', function ($q) {
            $q->where('published', 1);
        })
        ->orderBy('name', 'asc')->get();

        $anunciantes_destacados = Product::withCount(['reviews' => function ($q) {
            $q->where('published', true)->where('email_verified', true);
        }])
        ->withAvg(['reviews' => function ($q) {
            $q->where('published', true)->where('email_verified', true);
        }], 'rating')
        ->where([
            ['published', '=', 1],
            ['leading_home', '=', 1]
        ])->get()->map(function ($anunciante) {
            $anunciante->first_contact = $anunciante->contacts->first(); // Guarda solo el primer contacto
            $anunciante->average_rating = $anunciante->reviews_avg_rating
                ? round($anunciante->reviews_avg_rating, 1)
                : null;
            return $anunciante;
        });
        $ultimos_anunciantes = Product::where('published', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $articles = Article::with('authors', 'tags')
        ->where('published', 1)
        ->orderBy('created_at', 'desc')
        ->limit(6)
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

        // Leer la cookie
        $viewedCategoryIds = json_decode(Cookie::get('recently_viewed_categories'), true) ?? [];

        // Si hay categorías, traerlas de la DB en el mismo orden
        if (count($viewedCategoryIds) > 0) {
            $viewedCategories = Category::whereIn('id', $viewedCategoryIds)
                ->orderByRaw('FIELD(id, ' . implode(',', $viewedCategoryIds) . ')')
                ->get();
        } else {
            // Si no hay nada, devolver colección vacía para evitar errores
            $viewedCategories = collect();
        }

        $ultimasReviews = Review::where('published', 1)
            ->with('product:id,title,slug', 'product.categories:id,slug,name')  // Solo carga id y name del producto
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return view('welcome', compact(
            'homeherobanners',
            'categories',
            'anunciantes_destacados',
            'ultimos_anunciantes',
            'articles',
            'viewedProducts',
            'viewedCategories',
            'ultimasReviews'
        ));
    }

}
