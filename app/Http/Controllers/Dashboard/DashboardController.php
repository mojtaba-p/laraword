<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * generate dashboard main feed
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $tags = auth()->user()->followingTopics;
        $tags = isset($tags) ? $tags->pluck('followable_id')->toArray() : [];
        $followed_topics = Tag::find($tags);

        if (\request('topic') == null && \request(['following']) == null) {
            // show all tags articles
            $articles = Article::query()->with('tags')
                ->where('status', Article::STATUS_PUBLIC)
                ->whereHas('tags', function($query) use ($tags){
                    $query->whereIn('id', $tags);
                });

        } elseif (\request(['following']) != null) {
            // show following users articles
            $users = auth()->user()->followingUsers->pluck('followable_id')->toArray();

            $articles = Article::whereIn('user_id', $users)
                ->whereStatus(Article::STATUS_PUBLIC);
        } else {
            // show specific tag articles
            $articles = Tag::whereSlug(\request('topic'))->firstOrFail()
                ->articles()->whereStatus(Article::STATUS_PUBLIC);
        }

        $articles = $articles
            ->defaultSorting()
            ->paginate(5);

        return view('dashboard', compact('articles', 'followed_topics'));

    }

}
