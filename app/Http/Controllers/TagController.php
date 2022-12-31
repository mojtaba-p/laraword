<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag) : \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $articles = $tag->articles()->where('status', Article::STATUS_PUBLIC)
            ->defaultSorting()
            ->paginate(5);

        return view('tags.show', compact('tag', 'articles'));
    }
}
