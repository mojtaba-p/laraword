<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function show(Category $category) : \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $articles = $category->publishedArticles()
            ->defaultSorting()
            ->paginate(5);

        return view('categories.show', compact('category', 'articles'));
    }
}
