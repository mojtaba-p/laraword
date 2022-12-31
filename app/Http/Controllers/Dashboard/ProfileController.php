<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;


class ProfileController extends Controller
{
    /**
     * show user profiles page.
     */
    public function index() : \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $user = auth()->user();
        return view('dashboard.profiles.index', compact('user'));
    }

    /**
     * store user profiles.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate(['photo' => 'image|max:1024']);
        $validated = $request->validate([
            'name' => ['required', Rule::unique('users')->ignore(auth()->id())],
            'bio' => ['max:254'],
        ]);

        $validated['photo'] = $this->storePhoto($request->file('photo'));

        auth()->user()->update($validated + ['social' => $request->social]);

        return to_route('dashboard.profiles')->with(['success_status' => 'Profile Successfully Updated']);
    }

    /**
     * store photo of user in disk and photo name in db
     */
    protected function storePhoto($image_request) : string
    {
        if (!isset($image_request))
            return 'default.jpg';

        try {
            if (isset(auth()->user()->photo)) {
                unlink(public_path('profiles/' . auth()->user()->photo));
            }

            ensureMediaDirectoryExists('profiles');

            $random_name = md5(time()) . rand(1, 100) . '.webp';

            resizeWithAspectRatio(Image::make($image_request), 250)
                ->encode('webp', 90)
                ->save(public_path('profiles/' . $random_name));

            return $random_name;
        } catch (\Exception $e) {
            report($e);
            return 'cant upload image';
        }
    }

}
