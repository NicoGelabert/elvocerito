<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Verifica que query no esté vacío
        if (!$query) {
            return response()->json([]);
        }

        // Obtener productos basados en la búsqueda
        $products = Product::where('title', 'like', "%{$query}%")
            ->orWhereHas('categories', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->orWhereHas('tags', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->with([
                'categories' => function ($q) {
                    $q->select('categories.id', 'categories.name', 'categories.slug', 'categories.parent_id')
                      ->with('parent:id,name,slug');
                },
                'images'
            ])
            ->select('products.*')
            ->limit(10)  // Limitar la cantidad de resultados
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'short_description' => $product->short_description,
                    'categories' => $product->categories,
                    'image' => $product->images->first()?->url ?? null, // Extrae la primera imagen
                ];
            });
            $categories = Category::where('name', 'like', "%{$query}%")
            ->with('parent:id,name,slug') // Asegura que venga el padre
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $category->image ?? null, // si tenés imagen
                    'parent' => $category->parent ? [
                        'name' => $category->parent->name,
                        'slug' => $category->parent->slug,
                    ] : null,
                ];
            });

        // Devolver los resultados como JSON
        return response()->json([
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
