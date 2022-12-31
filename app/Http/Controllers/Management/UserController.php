<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('see', User::class);

        $users = User::where('id', '!=', auth()->id())
                ->with('articles');

        if(request('date') == null || request('date') == 'all'){
            $users = $users->withCount(['articles','likes','comments']);
        } else {
            $users = $users->limitToDate(request('order'), request('date'));
        }

        $users = $users->filterResults(request()->all())->paginate(20);

        return view('management.users.index', compact('users'));
    }

    public function updateRole(Request $request)
    {
        $this->authorize('updateRole', User::class);
        $result = $request->validate([
            'username' => 'required|exists:users,username',
            'role' => ['required', Rule::in(User::ROLES)]
        ]);

        $user = User::where('username', $request->username)->first();

        if(
            (!$user->hasRole(User::ADMIN)) ||
            ($user->hasRole(User::ADMIN) && auth()->user()->hasRole(User::ADMIN))
        ){
            $user->setRole($request->role);
        } else {
            return redirect()->back()->withErrors(['cant_update_admin' => __('You can\'t update admin user')]);
        }

        return redirect()->back()->with(['success_status', __('User role updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
