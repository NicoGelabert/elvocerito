<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::query();

        return $this->renderProducts($query);
    }

    public function byCategory(Category $category)
    {
        $categories = Category::getAllChildrenByParent($category);

        $query = Product::query()
            ->select('products.*')
            ->join('product_categories AS pc', 'pc.product_id', 'products.id')
            ->whereIn('pc.category_id', array_map(fn($c) => $c->id, $categories));

        return $this->renderProducts($query);
    }

    public function view($categorySlug, $productSlug)
    {
        // Obtener la categoría usando el slug
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        // Obtener el producto usando el slug
        $product = Product::where('slug', $productSlug)->firstOrFail();

        // Cargar el producto con sus relaciones
        $product->load(['categories', 'images', 'contacts', 'socials', 'addresses', 'horarios']);

        // Obtener los productos relacionados (si es necesario)
        $tags = $product->tags()->get();

        // --- Lógica para la cookie ---
        $viewedProducts = json_decode(Cookie::get('recently_viewed'), true) ?? [];

        // Remover el producto si ya está en la lista (para evitar duplicados)
        $viewedProducts = array_filter($viewedProducts, fn($id) => $id != $product->id);

        // Agregar el producto actual al inicio
        array_unshift($viewedProducts, $product->id);

        // Limitar a los últimos 5 productos
        $viewedProducts = array_slice($viewedProducts, 0, 5);

        // Guardar la cookie (duración: 7 días)
        Cookie::queue('recently_viewed', json_encode($viewedProducts), 60 * 24 * 7);

        // Retornar la vista con la información necesaria
        return view('product.view', [
            'product' => $product,
            'category' => $category,
            'tags' => $tags,
        ]);
    }


    public function urgencies(Product $products, Category $categories)
    {
        // Obtener los productos con las relaciones necesarias
        $products = Product::query()->where('urgencies', 1)
            ->with(['categories', 'images', 'contacts', 'socials', 'addresses']) // Sin categorías
            ->get();
            
        $categories = $products->pluck('categories')->flatten()->unique('id');
        $tags = $products->pluck('tags')->flatten()->unique('id');
        // Pasar solo los productos a la vista
        return view('product.urgencies', compact('products', 'categories', 'tags'));
    }

    private function renderProducts(Builder $query)
    {
        $search = \request()->get('search');
        $sort = \request()->get('sort', '-updated_at');

        if ($sort) {
            $sortDirection = 'asc';
            if ($sort[0] === '-') {
                $sortDirection = 'desc';
            }
            $sortField = preg_replace('/^-?/', '', $sort);

            $query->orderBy($sortField, $sortDirection);
        }
        $products = $query
            ->where('published', '=', 1)
            ->where(function ($query) use ($search) {
                /** @var $query \Illuminate\Database\Eloquent\Builder */
                $query->where('products.title', 'like', "%$search%")
                    ->orWhere('products.description', 'like', "%$search%");
            })

            ->paginate(5);

        return view('product.index', [
            'products' => $products
        ]);

    }

}
