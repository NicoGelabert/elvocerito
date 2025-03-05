<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
            ->select('id', 'title', 'slug')  // Seleccionar solo lo necesario
            ->limit(10)  // Limitar la cantidad de resultados
            ->get();

        // Devolver los resultados como JSON
        return response()->json($products);
    }
}
