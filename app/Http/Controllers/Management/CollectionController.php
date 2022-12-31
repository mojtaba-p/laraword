<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Collection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index() : \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->authorize('see', Collection::class);
        $collections = Collection::paginate(20);
        return view('management.collections.index', compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create() : \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->authorize('create', Collection::class);

        return view('management.collections.create');
    }

    /**
     *  Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(CollectionRequest $request) : \Illuminate\Http\RedirectResponse
    {
        $this->authorize('create', Collection::class);
        $collection = Collection::create(['name' => $request->name]);

        $collection->articles()->sync(Article::whereIn('slug', $request->articles)->get());

        return to_route('management.collections.index')->with('success_status', __('Collection Successfully Created'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
//        return to_route()
    }


    /**
     * Show the form for editing the specified resource.
     * @throws AuthorizationException
     */
    public function edit(Collection $collection) : \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->authorize('create', Collection::class);
        $collection->load('articles');
        $init_value = ArticleResource::collection($collection->articles)->toJson();
        return view('management.collections.edit', compact('collection', 'init_value'));
    }

    /**
     * Update the specified resource in storage
     * @throws AuthorizationException
     */
    public function update(CollectionRequest $request, Collection $collection) : \Illuminate\Http\RedirectResponse
    {
        $this->authorize('create', Collection::class);
        $collection->update(request(['name']));
        $collection->articles()->sync(Article::whereIn('slug', $request->articles)->get());
        return to_route('management.collections.index')->with('success_status', __('Collection Successfully Updated'));
    }


    /**
     * add single article to a collection.
     * @throws AuthorizationException
     */
    public function attachSingleArticle(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('add', Collection::class);
        $request->validate(['article' => 'required|exists:articles,slug', 'collection' => 'required|exists:collections,slug']);
        Collection::where('slug', $request->collection)
            ->firstOrFail()
            ->articles()
            ->attach(
                Article::where('slug', $request->article)->firstOrFail()
            );
        return redirect()->back()->with('success_status', __('Successfully Added To Collection'));
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Collection $collection): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('create', Collection::class);

        $collection->delete();
        return to_route('management.collections.index')->with('success_status', __('Collection Successfully Deleted'));
    }
}
