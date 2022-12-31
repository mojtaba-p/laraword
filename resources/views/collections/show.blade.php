<x-main-layout>
    <x-container-fluid>
        <x-partials.one-column-list :articles="$articles">
            <x-slot name="title">
                <span class="font-black">{{ strtoupper($collection->name) }}</span> articles.
            </x-slot>
        </x-partials.one-column-list>
        {{ $articles->links() }}
    </x-container-fluid>

</x-main-layout>
