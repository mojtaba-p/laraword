<x-app-layout class="bg-gray-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Collection') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('management.collections.update', $collection) }}" method="post">
                @csrf
                @method('put')

                @include('management.collections._fields', ['collection' => $collection])
                <x-primary-button class="mt-3">
                    {{ __('Update Collection') }}
                </x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
