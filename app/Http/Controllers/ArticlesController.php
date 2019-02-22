<?php

namespace App\Http\Controllers;

use App\Article;

class ArticlesController extends Controller
{
    /**
     * Show the article.
     *
     * @param  Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }
}
