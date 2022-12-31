<nav class="flex flex-row space-x-8 w-full p-5 text-2xl">
    <x-nav-link :href="'/search?q='.request('q')"
                :active="$result_type == 'article'">
        {{ __('Articles') }}
    </x-nav-link>

    <x-nav-link :href="'/search/people?q='.request('q')"
                :active="$result_type == 'people'">
        {{ __('People') }}
    </x-nav-link>

    <x-nav-link :href="'/search/topics?q='.request('q')"
                :active="$result_type == 'topics'">
        {{ __('People') }}
    </x-nav-link>

</nav>
