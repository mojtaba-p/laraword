<x-main-layout>
    <x-container-fluid>
        @include('search._navigation')
        <x-partials.one-column-list :articles="$articles">
            <x-slot:title>
                Article search results for <span class="font-bold">{{ request('q') }}</span>
            </x-slot:title>
        </x-partials.one-column-list>
        {{ $articles->appends(request()->input())->links() }}
    </x-container-fluid>
</x-main-layout>
