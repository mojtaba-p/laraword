@props(['article','categories'])
@push('head-scripts')
    <script src="/ckeditor.js"></script>
    @vite(['resources/js/ckeditor.conf.js'])
@endpush
@include('components.articles._form-fields-nav')
<div x-show="options_dialog">
    <div
        class="w-2/3 fixed mx-auto left-0 right-0 top-0 bg-white z-20 overflow-x-hidden overflow-y-auto max-h-full top-5">
        @include('components.articles._options')
    </div>
    <div class="w-full fixed top-0 left-0 bg-black h-full z-10 opacity-25"
         @click="options_dialog=!options_dialog"></div>
</div>

<div
    class="overflow-hidden flex flex-col-reverse md:flex-row space-x-2 space-y-reverse space-y-10 md:space-y-0 mb-2 mt-5">
    <input type="hidden" name="status" value="publish" x-ref="status">
    <div class="w-full">
        <div class="bg-white  p-6 border-b border-gray-200">
            <input type="hidden" name="path" id="content-path" value="{{ route('dashboard.users.images.store') }}">

            <div class="block mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md text-2xl font-bold"
                       placeholder="Title"
                       value="{{ old('title', $article->title) }}" autofocus required>
                <x-input-error :messages="$errors->get('title')" class="mt-2 border-2 border-red-500 p-2 rounded-md"/>
            </div>

            <div class="block mb-3">

                <div id="content" name="content" x-ref="editor">{!!  old('content', $article->content)  !!}</div>
                <textarea name="content" cols="30" rows="10"
                          class="hidden" x-ref="content"></textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2 border-2 border-red-500 p-2 rounded-md"/>

            </div>

        </div>
    </div>
</div>
