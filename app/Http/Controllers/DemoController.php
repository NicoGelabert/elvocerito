<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::query()
            ->where('published', '=', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
            return view('layouts.demo.welcome', [
            'products' => $products
        ]);
    }
}
