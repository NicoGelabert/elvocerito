<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('published', 1)->orderBy('created_at', 'desc')->paginate(16);
        return view('news.index', [
            'articles' => $articles
        ]);
    }

    public function view(Article $article)
    {
        $article->load(['authors.articles', 'images', 'tags']);
        // $articles = article::all();
        return view('news.view', compact('article'));
    }
}
