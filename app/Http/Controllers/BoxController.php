<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\User;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    public function index(User $user)
    {
        $boxes = $user->boxes()->with('bookmarks.article')->paginate(20);
        return view('boxes.index', compact('boxes', 'user'));
    }

    public function show(User $user, Box $box)
    {
        if(!$box->user->is($user)) abort(404);
        $bookmarks = $box->bookmarks()->with('article')->paginate(50);
        return view('boxes.show', compact('user', 'box', 'bookmarks'));
    }


}
