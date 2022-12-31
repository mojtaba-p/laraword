<nav class="flex flex-row space-x-8 w-full p-5 text-2xl">
    <x-nav-link :href="route('users.profile', $user)"
                :active="request()->routeIs('users.profile')">
        {{ __('Articles') }}
    </x-nav-link>

    <x-nav-link :href="route('users.boxes', $user)"
                :active="request()->routeIs('users.boxes') || request()->routeIs('users.boxes.*')">
        {{ __('Boxes') }}
    </x-nav-link>
</nav>
