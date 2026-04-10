<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::whereHas('products', function ($q) {
            $q->where('published', 1);
        })
        ->orderBy('name', 'asc')
        ->get();

        return view('categories.index', compact('categories'));
    }


    public function view(Category $category)
    {
        $subcategories = $category->children()->where('active', 1)->get();
        
        $categoryIds = $subcategories->pluck('id')->push($category->id);

        $products = Product::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })
        ->where('published', 1)
        ->with(['images', 'categories', 'tags', 'contacts', 'socials', 'categories.parent'])
        ->get();

        $tags = $products->pluck('tags')->flatten()->unique('id')->values();
        
        return view('categories.view', compact('category', 'subcategories', 'products', 'tags'));
    }

    public function viewSubcategory($category, $subcategory)
    {
        $category = Category::where('slug', $category)->firstOrFail();
        $subcategory = Category::where('slug', $subcategory)
        ->where('parent_id', $category->id)
        ->firstOrFail();
        $subcategory->load('products');
        $products = $subcategory->products()->where('published', 1)->with(['images', 'categories', 'tags', 'contacts', 'categories.parent'])->get();
        $tags = $products->pluck('tags')->flatten()->unique('id')->values();
        return view('categories.subcategory', compact('category', 'subcategory', 'products', 'tags'));
    }

    public function indexJson()
    {
        $categories = Category::whereHas('products', function ($q) {
            $q->where('published', 1);
        })
        ->orderBy('name', 'asc')
        ->get();
        $grouped = $categories->groupBy(function ($category) {
            return strtoupper(substr($category->name, 0, 1));
        })->map(function ($group) {
            return $group->values(); // Reindexa cada grupo
        });

        return response()->json([
            'categories' => $grouped
        ]);
    }
}
