<x-app-layout  class="bg-gray-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('management.categories.store') }}" method="POST">
                        @csrf
                        <div class="block mb-3">
                            <label for="name">Title</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md"
                                   value="{{ old('name') }}">
                            @error('name')
                            {{ $message }}
                            @enderror
                        </div>
                        <button type="submit" class="btn-blue">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
