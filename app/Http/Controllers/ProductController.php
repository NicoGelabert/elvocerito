<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

    public function view(Category $category, Product $product)
    {
        $product->load(['categories', 'images','contacts', 'socials', 'addresses']);
        return view('product.view', ['product' => $product, 'category' => $category]);
    }

    public function urgencies(Product $products, Category $categories)
    {
        // Obtener los productos con las relaciones necesarias
        $products = Product::query()->where('urgencies', 1)
            ->with(['categories', 'images', 'contacts', 'socials', 'addresses']) // Sin categorías
            ->get();

        $categories = $products->pluck('categories')->flatten()->unique('id');

        // Pasar solo los productos a la vista
        return view('product.urgencies', ['products' => $products, 'categories' => $categories]);
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
