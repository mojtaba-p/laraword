<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $articles = $user->articles()->with('category')->withCount('comments')->paginate(5);

        return view('users.show', compact('user', 'articles'));
    }

}
