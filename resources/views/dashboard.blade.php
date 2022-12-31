<x-app-layout class="bg-gray-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8  flex flex-col md:flex-row">
            @if($articles->count() > 0 || $followed_topics->count() > 0)
                @include('dashboard._partials.feed')
            @else
                @include('dashboard._partials.interests')
            @endif
        </div>

    </div>
</x-app-layout>
