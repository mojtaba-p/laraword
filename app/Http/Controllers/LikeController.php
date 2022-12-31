<?php

namespace App\Http\Controllers;

use App\Events\Liked;
use App\Events\LikedArticleComment;
use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function handleArticle(Article $article)
    {
        return $this->handle($article);
    }

    public function handleArticleComment(ArticleComment $comment)
    {
        return $this->handle($comment);
    }

    /**
     * like or dislike subject.
     *
     * @param Model $model
     * @return \Illuminate\Http\Response
     */
    public function handle(Model $model)
    {

        if($model->isLikedBy(auth()->user())){
            $model->unLike(auth()->user());
        } else {
            // don't send notification for themselves
            if(!(auth()->user()->is($model->writer) || auth()->user()->is($model->author))){
                event(new Liked($model, auth()->user()));
            }
            $model->addLike(auth()->user());
        }

        $model->refresh();


        return response()->json(['likes_count' => $model->likes_count]);
    }
}
