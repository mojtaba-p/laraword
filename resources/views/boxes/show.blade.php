<x-main-layout>
    <x-container-fluid>
        <div class="flex flex-wrap line">
            <div class="w-full md:w-3/4 pr-4">
                @include('users._navigation')
                <x-partials.one-column-list :articles="$bookmarks->pluck('article')">
                    <x-slot:title>
                        Bookmarks in {{ $box->name }} Box
                    </x-slot:title>
                </x-partials.one-column-list>
            </div>
            @include('users._user-info')
        </div>
        {{ $bookmarks->links() }}
    </x-container-fluid>
</x-main-layout>
