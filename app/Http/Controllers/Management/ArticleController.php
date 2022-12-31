<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\{Article, Category, Collection, Tag};
use App\Traits\HasImage;
use Faker\Core\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{

    /**
     * Display a listing of the articles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('seeAll', Article::class);

        $articles = Article::query();
        $categories = Category::all();
        // if can add to collection
        $collections = Collection::all()->pluck('name', 'slug');

        $articles = $articles->filterResults(request()->all())->limitToDate(request()->date)->paginate(15);
        return view('management.articles.index', compact('articles', 'collections','categories'));
    }


}
