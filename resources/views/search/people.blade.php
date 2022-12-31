<x-main-layout>
    <x-container-fluid>
        @include('search._navigation')
        <x-partials.line/>
        <h2 class="my-5 font-bold text-xl">
            People Search results for <span class="font-bold">{{ request('q') }}</span>
        </h2>
        <div class="flex flex-wrap mt-5">
            @forelse($users as $user)
                <div class="w-1/2 flex flex-row items-center mb-2">
                    <div class="w-1/6">
                        <x-user-photo :user="$user" class="w-full h-fit rounded-full overflow-hidden"/>
                    </div>
                    <div class="w-5/7 ml-5 p-2">
                        <a href='/{{ '@'.$user->username }}' class="text-lg">{{ $user->name }}</a>
                        <p class="text-sm text-gray-500">{{ Str::limit($user->bio, 50) }}</p>
                    </div>
                </div>
            @empty
                No people found here
            @endforelse
        </div>
        {{ $users->appends(request()->input())->links() }}
    </x-container-fluid>
</x-main-layout>
