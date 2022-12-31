<x-app-layout class="bg-gray-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @include('dashboard._partials.success-message')

        <div class="flex flex-col-reverse md:flex-row items-center mb-5">
            <div class="flex flex-row items-center">
                <div class="md:ml-auto md:mr-0">
                    <a href="{{ route('management.categories.create') }}"
                       class="primary-create-btn">{{ __('New Category') }} <span class="font-bold">+</span></a>
                </div>
            </div>
        </div>


        @foreach ($categories as $category)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('management.categories.edit', $category) }}">{{ $category->name }}</a>
                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>
