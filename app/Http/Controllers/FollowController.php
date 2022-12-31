<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class FollowController extends Controller
{
    /**
     * Store Author in users following list.
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $user = User::whereUsername($request->username)->firstOrFail();
        $follower = auth()->user();

        if (!$follower->doesFollow($user)) {
            $user->addFollower($follower);
        } else {
            $user->removeFollower($follower);
        }

        return redirect()->back();
    }

    /**
     * store tag in users following tags list
     */
    public function storeTopic(Request $request): RedirectResponse
    {
        $topic = Tag::whereSlug($request->tag)->firstOrFail();
        $follower = auth()->user();
        if (!$follower->doesFollow($topic)) {
            $topic->addFollower($follower);
        } else {
            $topic->removeFollower($follower);
        }
        return redirect()->back();
    }

    /**
     * store user interested topics
     */
    public function storeInterests(Request $request) : \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    {
        $request->validate(['interested_topics' => ['required', 'exists:tags,slug']]);
        $tags = Tag::whereIn('slug', $request->interested_topics)->get();
        $follower = auth()->user();
        foreach ($tags as $tag) {
            if (!$follower->doesFollow($tag))
                $tag->addFollower($follower);
        }
        return redirect('dashboard');
    }

    /**
     * specifies a user or tag is followed or not.
     */
    public function show(Request $request) : \Illuminate\Http\JsonResponse
    {
        if (isset($request->username)) {
            $response = auth()->user()->followingUsers->contains(User::whereUsername($request->username)->firstOrFail()->id);
        }

        if (isset($request->tag)) {
            $response = auth()->user()->followingTopics->contains(Tag::whereSlug($request->tag)->firstOrFail()->id);
        }

        return response()->json($response);
    }


}
