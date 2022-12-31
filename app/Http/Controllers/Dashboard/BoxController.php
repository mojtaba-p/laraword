<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Box;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BoxController extends Controller
{
    public function index()
    {
        return response()->json( auth()->user()->boxes()->get(['name', 'slug', 'private']));
    }

    /**
     * store box in database
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['name' => 'required', 'private' => 'boolean']);
        if (auth()->user()->boxes()->whereName(trim($request->name))->exists()) abort(422, 'Box Exists');
        auth()->user()->boxes()->create($request->only('name', 'private'));
        return response()->json(['success' => true]);
    }

    /**
     * update existing box with given values
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Box $box, Request $request)
    {
        $this->authorize('update', $box);
        $request->validate(['name' => 'required', 'private' => 'boolean']);
        $box->update($request->only(['name', 'private']));
        return response()->json($box->only('name', 'slug', 'private'));
    }

    /**
     * delete given box.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Box $box)
    {
        $this->authorize('delete', $box);
        $box->delete();
        return response()->noContent();
    }

}
