<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\Commented;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCommentRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleCommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     *
     * @param \App\Models\Article       $article
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Article $article, ArticleCommentRequest $request)
    {
        if($request->has('parent_id')){
            $comment = $article->comments()->find($request->parent_id);
            $comment->addReply($request->validated());
            $commented = $comment;
        } else{
            $article->addComment($request->validated());
            $commented = $article;
        }

        if(!(auth()->user()->is($commented->writer) || auth()->user()->is($commented->author))) {
            event(new Commented($commented, auth()->user()));
        }

        return to_route('articles.show', $article)->with(['comment.success' => true]);

    }

}
