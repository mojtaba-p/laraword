<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $articles = Article::paginate(20);

        return view('articles.index', compact('articles'));
    }

    /* Display the specified Article.
    *
    * @param  \App\Models\Tag  $tag
    * @return \Illuminate\Http\Response
    */
    public function show(Article $article)
    {
        $top_notification = null;
        if (!$article->isPublished()) {
            if (!auth()->check()) {
                return abort(404);
            }
            $this->authorize('edit', $article); // article owner can see preview of article on draft mode
            $top_notification = __('This article is not published and only you can see this page.');
            $top_notification .= ' Change status in <a class="font-black" href="' .
                route('dashboard.articles.edit', $article) . '">Edit</a> page.';
        }

        $article->load(['category', 'tags', 'author'])->loadCount('comments');
        $article->seen();

        $comments = $article->getComments();
        $related_articles = $article->relatedArticles()->take(4);

        return view('articles.show', compact('article', 'comments',
                                                            'top_notification', 'related_articles'));
    }


    public function titleSearch(String $search)
    {
        return ArticleResource::collection(Article::where('status' , 1)->where('title','like', '%'.$search.'%')->orderBy('created_at', 'desc')->get());
    }
}
