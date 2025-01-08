<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        return view('categories.index', [
            'categories' => $categories
        ]);
    }

    public function view(Categories $categories)
    {
        return view('categories.view', ['categories' => $categories]);
    }

}
