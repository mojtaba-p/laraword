<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Box;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookmarkController extends Controller
{
    public function index()
    {
        return \response()->json(auth()->user()->bookmarks()->with(['article' => function ($query) {
            $query->select(['slug', 'id']);
        }])->get()->pluck('article')->pluck('slug'));
    }

    // mark an article as bookmark
    public function store(Request $request, Article $article): \Illuminate\Http\JsonResponse
    {
        if (!isset($request->boxes) || empty($request->boxes)) {
            auth()->user()->bookmarks()->where(['article_id' => $article->id])->first()->delete();
            return response()->json('');
        } else {
            $bookmark = auth()->user()->bookmarks()->firstOrCreate(['article_id' => $article->id]);
            $boxes = auth()->user()->boxes()->whereIn('slug', $request->boxes)->get();
            $bookmark->boxes()->sync($boxes);
        }

        return response()->json(['boxes' => $bookmark->boxes()->pluck('slug')]);
    }

    public function boxes(Article $article)
    {
        $bookmark = auth()->user()->bookmarks()->where('article_id', $article->id)->first();

        if ($bookmark) {
            return response()->json(['boxes' => $bookmark->boxes()->pluck('slug')]);
        }

        return response()->json('');
    }

    public function allBoxesList($bookmark_id)
    {
        return auth()->user()->bookmarks()->findOrFail($bookmark_id)->boxes()->pluck('slug')->toJson();
    }
}
