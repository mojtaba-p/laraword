<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Article;
use App\Models\Collection;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // @todo cleaner way to generate first page
        $pinned_article = Article::whereNotNull('pinned_at')->orderBy('pinned_at', 'desc')->first();
        $discover_links = Tag::popularTags(15)->get();

        $editors_pick['collection'] = Collection::where('name', "Editor's Pick")->first();
        if (isset($editors_pick['collection']))
            $editors_pick['articles'] = $editors_pick['collection']->articles()->with(['category', 'author'])
                ->orderByPivot('created_at', 'desc')
                ->take(4)->get();

        $top_2022['collection'] = Collection::where('name', "2022 Selective")->first();
        if ($top_2022['collection'])
            $top_2022['articles'] = $top_2022['collection']->articles()->with(['category', 'author'])->take(6)->get();

        $top_viewed_lw_articles = Article::where('status', Article::STATUS_PUBLIC)
            ->with(['category'])
            ->where('created_at', '>', now()->subDays(7)->startOfDay())
            ->orderBy('views_count', 'desc')
            ->take(20)->get();

        $new_articles = Article::where('status', Article::STATUS_PUBLIC)
            ->orderBy('created_at', 'desc')->take(10)->get();

        return view('home',
            compact('discover_links', 'editors_pick', 'top_viewed_lw_articles',
                'new_articles', 'top_2022', 'pinned_article'));
    }
}
