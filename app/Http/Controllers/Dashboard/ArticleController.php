<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\{Article, Category, Collection, Tag};
use App\Traits\HasImage;
use Faker\Core\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{

    /**
     * Show the form for creating a new article.
     */
    public function create(): \Illuminate\View\View
    {
        $categories = Category::all();
        return view('dashboard.articles.create', compact('categories'));
    }

    /**
     * Display a listing of the articles.
    */
    public function index(): \Illuminate\View\View
    {
        $articles = auth()->user()->articles();
        $categories = Category::all();

        if (isset(request()->order))
            $articles->orderResults(request()->order, request()->sort);
        else
            $articles->orderBy('updated_at', 'desc');

        $articles = $articles->filterResults(request()->all())->limitToDate(request()->date)->paginate(15);
        return view('dashboard.articles.index', compact('articles', 'categories'));
    }


    public function show(Article $article): RedirectResponse
    {
        return to_route('articles.show', $article);
    }


    /**
     * Store a newly created category in storage.
     */
    public function store(ArticleRequest $request): RedirectResponse
    {

        $article = auth()->user()->articles()->create(
            $request->safe()->except('thumbnail')
        );

        $article->syncThumbnail($request->file('thumbnail'));

        $article->syncTags($request->input('tags'));

        return to_route('dashboard.articles.index')->with(['success_status' => __('Article Created Successfully')]);
    }


    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article): \Illuminate\View\View
    {
        $this->authorize('edit', $article)->withStatus(404);
        $categories = Category::all();
        return view('dashboard.articles.edit', compact('article', 'categories'));
    }


    /**
     * Update the specified category in storage.
     */
    public function update(Article $article, ArticleRequest $request): RedirectResponse
    {
        $this->authorize('update', $article);

        $article->update( $request->safe()->except('thumbnail') );

        $article->syncThumbnail($request->file('thumbnail'));

        $article->syncTags($request->input('tags'));

        return to_route('dashboard.articles.index')->with(['success_status' => __('Article Updated Successfully')]);
    }

    /**
     * mark article as pinned to home page
     */
    public function markAsPinned(Article $article): RedirectResponse
    {
        $article->markAsPinned();
        return redirect()->back()->with('success_status', __('Article Successfully Pinned'));
    }

    /**
     * upload image from ckeditor and return url to ckeditor
     */
    public function contentImage(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['image' => 'image|max:1024',]);
        $image_info = getimagesize($request->file('image'));

        $resize = max($image_info[0], $image_info[1]) > 1024 ? 1024 : null;

        $address = uploadImage(
            $request->file('image'),
            auth()->user()->mediaDir(),
            uniqueNameGenerator(auth()->user()->mediaDir()),
            'webp',
            95,
            $resize
        );

        return response()->json(['url' => auth()->user()->mediaPath($address)]);
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article):Response
    {
        $article->delete();
        return response()->noContent();
    }
}
