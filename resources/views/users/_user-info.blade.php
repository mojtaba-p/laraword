<div class="w-full md:w-1/4 border-l-2 pl-4">
    <div class="w-full md:w-1/2 mx-auto">
        <x-user-photo :user="$user" class="w-full h-fit rounded-full overflow-hidden"/>
    </div>
    <h3 class="font-bold">{{ $user->name }}</h3>
    <h4 class="text-gray-500 font-bold">{{ $user->followersCount() }} Followers</h4>
    <p class="my-2">
        {{ $user->bio }}
    </p>
    <div class="flex flex-row space-x-3">
        <x-social-link-icons :user="$user"/>
    </div>

    @if(auth()->check())
        @if(auth()->user()->id != $user->id)
            <form action="{{ route('follow.store.user') }}" method="post">
                @csrf
                <input type="hidden" name="username" value="{{ $user->username }}">
                @if(auth()->user()->doesFollow($user))
                    <button class="primary-indigo-btn-outline mt-5 bg-white border-2 border-indigo-600">
                        Unfollow
                    </button>
                @else
                    <button class="primary-indigo-btn mt-5 inline-block">Follow +</button>
                @endif
            </form>
        @endif
    @else
        <a href="{{ route('login') }}?redirect_to={{ route('users.profile', $user) }}"
           class="primary-indigo-btn mt-5 inline-block">Follow +</a>
    @endif
</div>
