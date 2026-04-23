<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = collect();
        $categories = collect();

        if ($query) {
            $products = Product::withCount(['reviews' => function ($q) {
                $q->where('published', true)->where('email_verified', true);
            }])
            ->withAvg(['reviews' => function ($q) {
                $q->where('published', true)->where('email_verified', true);
            }], 'rating')
            ->where('published', 1)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('client_number', 'like', "%{$query}%")
                  ->orWhereHas('categories', function ($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  })
                  ->orWhereHas('tags', function ($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  });
            })
            ->with([
                'categories' => function ($q) {
                    $q->select('categories.id', 'categories.name', 'categories.slug', 'categories.parent_id')
                      ->with('parent:id,name,slug');
                },
                'images'
            ])
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'short_description' => $product->short_description,
                    'categories' => $product->categories,
                    'image' => $product->images->first()?->url ?? null,
                    'reviews_count' => $product->reviews_count,
                    'average_rating' => $product->reviews_avg_rating
                        ? round($product->reviews_avg_rating, 1)
                        : null,
                ];
            });

            $categories = Category::where('name', 'like', "%{$query}%")
                ->with('parent:id,name,slug')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'image' => $category->image ?? null,
                        'parent' => $category->parent ? [
                            'name' => $category->parent->name,
                            'slug' => $category->parent->slug,
                        ] : null,
                    ];
                });
        }

        $viewedProductsIds = json_decode(Cookie::get('recently_viewed'), true) ?? [];
        $viewedProducts = count($viewedProductsIds)
            ? Product::withCount(['reviews' => function ($q) {
                $q->where('published', true)->where('email_verified', true);
                }])
                ->withAvg(['reviews' => function ($q) {
                    $q->where('published', true)->where('email_verified', true);
                    }], 'rating')
                ->whereIn('id', $viewedProductsIds)
                ->orderByRaw('FIELD(id, ' . implode(',', $viewedProductsIds) . ')')
                ->with(['categories:id,name,slug', 'images'])
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'title' => $product->title,
                        'slug' => $product->slug,
                        'categories' => $product->categories,
                        'image' => $product->images->first()?->url ?? null,
                        'reviews_count' => $product->reviews_count,
                        'average_rating' => $product->reviews_avg_rating
                        ? round($product->reviews_avg_rating, 1)
                        : null,
                    ];
                })
            : collect();

        $viewedCategoryIds = json_decode(Cookie::get('recently_viewed_categories'), true) ?? [];
        $viewedCategories = count($viewedCategoryIds)
            ? Category::whereIn('id', $viewedCategoryIds)
                ->orderByRaw('FIELD(id, ' . implode(',', $viewedCategoryIds) . ')')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'image' => $category->image ?? null,
                    ];
                })
            : collect();

        $anunciantes_destacados = Product::withCount(['reviews' => function ($q) {
            $q->where('published', true)->where('email_verified', true);
        }])
        ->withAvg(['reviews' => function ($q) {
            $q->where('published', true)->where('email_verified', true);
        }], 'rating')
        ->where('published', 1)
        ->where('leading_home', 1)
        ->with(['categories', 'images'])
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'categories' => $product->categories,
                'image' => $product->images->first()?->url ?? null,
                'reviews_count' => $product->reviews_count,
                'average_rating' => $product->reviews_avg_rating
                ? round($product->reviews_avg_rating, 1)
                : null,
            ];
        });

        $popularCategories = Category::withCount(['products' => function ($q) {
            $q->where('published', 1);
        }])
        ->whereHas('products', function ($q) {
            $q->where('published', 1);
        })
        ->where('active', 1)
        ->orderByDesc('products_count')
        ->limit(5)
        ->get()
        ->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'image' => $category->image ?? null,
            ];
        });

        return response()->json([
            'products' => $products,
            'categories' => $categories,
            'viewedProducts' => $viewedProducts,
            'viewedCategories' => $viewedCategories,
            'anunciantes_destacados' => $anunciantes_destacados,
            'popularCategories' => $popularCategories,
        ]);
    }
}
