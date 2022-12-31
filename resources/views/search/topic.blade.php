<x-main-layout>
    <x-container-fluid>
        @include('search._navigation')
        <x-partials.line/>
        <h2 class="my-5 font-bold text-xl">
            Topic search results for <span class="font-bold">{{ request('q') }}</span>
        </h2>
        <div class="flex flex-wrap mt-5">
            @forelse($tags as $tag)
                <a href="/tags/{{ $tag->slug }}"
                   class="px-2 bg-gray-100 hover:bg-gray-300 rounded-md border-2 mr-3 mb-3">
                    {{ $tag->name }}
                </a>
            @empty
                No topics found here
            @endforelse
        </div>
        {{ $tags->appends(request()->input())->links() }}
    </x-container-fluid>
</x-main-layout>
