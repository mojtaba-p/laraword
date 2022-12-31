<x-app-layout class="bg-gray-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Collections') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @include('dashboard._partials.success-message')
        <div class="flex flex-wrap mb-2">
            <a href="{{ route('management.collections.create') }}" class="primary-create-btn">New Collection</a>
        </div>
        @foreach ($collections as $collection)
            <div class="mb-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg
                    flex flex-row items-center bg-white border-b border-gray-200">
                    <div class="p-6  md:w-7/12">
                        <a href="{{ route('management.collections.edit', $collection) }}">{{ $collection->name }}</a>
                    </div>
                    <div class="md:w-1/24 p-3 mx-3 flex flex-row rounded-xl space-x-2">
{{--                        <a href="{{ route('collections.show', $collection) }}">--}}
                            <x-svg.tr-arrow class="w-3.5"/>
{{--                        </a>--}}
                    </div>

                    <div class="md:w-1/24  p-2 mx-3 flex flex-row rounded-xl space-x-2">
                        <x-svg.document-text class="w-4" />
                        <span>{{ $collection->articles->count() }}</span>
                    </div>
                    <div class="md:w-1/24  p-2 mx-3 flex flex-row rounded-xl space-x-2">
                        <form action="{{ route('management.collections.destroy', $collection) }}" method="post">
                            @csrf
                            @method('delete')
                            <x-primary-button class="mt-3 bg-red-700 hover:bg-red-900 mt-0">
                                {{ __('Delete') }}
                            </x-primary-button>
                        </form>
                    </div>

                </div>
            </div>
        @endforeach
        {{ $collections->appends($_GET)->links() }}

    </div>

</x-app-layout>
