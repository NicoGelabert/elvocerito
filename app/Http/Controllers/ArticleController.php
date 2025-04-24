<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function view(Article $article)
    {
        $article->load(['authors', 'images']);
        // $articles = article::all();
        return view('news.view', [
            'article' => $article,
        ]);
    }
}
