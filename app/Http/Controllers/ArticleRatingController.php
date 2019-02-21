<?php

namespace App\Http\Controllers;

use App\Article;

class ArticleRatingController extends Controller
{
    /**
     * Rate the given article.
     *
     * @param \App\Article $article
     */
    public function store(Article $article)
    {
        request()->validate([
            'rating' => ['required', 'in:1,2,3,4,5']
        ]);

        $article->rate(request('rating'));
    }
}
