<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * return article search results
     */
    public function article() : \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $query = $this->simpleValidate(\request('q'));

        $articles = Article::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->where('status', Article::STATUS_PUBLIC)
            ->paginate(20);
        $result_type = 'article';
        return view('search.article', compact('result_type', 'articles'));
    }

    /**
     * return user search results.
     */
    public function people() : \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $query = $this->simpleValidate(\request('q'));


        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('bio', 'like', "%{$query}%")
            ->orWhereHas('articles', function ($builder) use ($query) {
                $builder->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->where('status', Article::STATUS_PUBLIC);
            })
            ->paginate(20);
        $result_type = 'people';
        return view('search.people', compact('result_type', 'users'));
    }

    /**
     * return tag search results
     */
    public function topics() : \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $query = $this->simpleValidate(\request('q'));

        $tags = Tag::where('name', 'like', "%{$query}%") ->paginate(20);

        $result_type = 'topics';
        return view('search.topic', compact('result_type', 'tags'));
    }

    /** simple validating and check query string is not null */
    protected function simpleValidate($query)
    {
        if (!isset($query)) {
            abort(404, __('Empty search not allowed'));
        }
        return $query;
    }
}
