<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::all();
        return view('management.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('management.categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  CategoryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return to_route('management.categories.index')->with(['success_status' => __('Category Successfully Created')]);
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  Category $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('management.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  CategoryRequest  $request
     * @param  Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return to_route('management.categories.index')->with(['success_status' => __('Category Successfully Updated')]);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
