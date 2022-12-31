<x-main-layout>
    <x-container-fluid>
        <div class="flex flex-wrap line">
            @include('users._navigation')
            <div class="w-full md:w-3/4 pr-4">
                <x-partials.one-column-list :articles="$articles">
                    <x-slot:title>
                        Articles of {{ $user->name }}
                    </x-slot:title>
                </x-partials.one-column-list>
            </div>
            @include('users._user-info')
        </div>
        {{ $articles->links() }}
    </x-container-fluid>
</x-main-layout>
