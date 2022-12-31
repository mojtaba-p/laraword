<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function show(Collection $collection)
    {
        $articles = $collection->articles()->orderByPivot('created_at','desc')->paginate(5);
        return view('collections.show', compact('collection','articles'));
    }
}
