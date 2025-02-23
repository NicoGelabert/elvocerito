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
        $subcategories = $category->children()->where('active', true)->get();

        return view('categories.view', compact('category', 'subcategories'));
    }

    public function viewSubcategory($categorySlug, $subcategorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $subcategory = Category::where('slug', $subcategorySlug)
            ->where('parent_id', $category->id)
            ->firstOrFail();

        return view('categories.subcategory', compact('category', 'subcategory'));
    }
}
