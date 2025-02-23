<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::getActiveAsTree();
        return view('categories.index', compact('categories'));
    }

    public function view(Category $category)
    {
        // Cargar las subcategorías relacionadas
        $subcategories = $category->children()->where('active', 1)->get();
        $products = Product::whereHas('categories', function ($query) use ($subcategories) {
            $query->whereIn('categories.id', $subcategories->pluck('id'));
        })->where('published', 1)->with(['images', 'categories'])->get();
        // dd($products);
        return view('categories.view', compact('category', 'subcategories', 'products'));
    }

    public function viewSubcategory($category, $subcategory)
    {
        $category = Category::where('slug', $category)->firstOrFail();
        $subcategory = Category::where('slug', $subcategory)
        ->where('parent_id', $category->id)
        ->firstOrFail();
        $subcategory->load('products');
        $products = $subcategory->products()->where('published', 1)->get();
        return view('categories.subcategory', compact('category', 'subcategory', 'products'));
    }
}
