<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts._head')
<body {{ $attributes->merge(['class' => 'font-serif antialiased']) }}>
<div {{ $attributes->merge(['class'=>"min-h-screen"]) }}>
    @include('layouts.navigation')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main x-data="{ showNewBoxModal : false, boxes:[], bookmarks:[]}"
          x-init="fetchBoxes().then(response => boxes = response);
          fetchBookmarks().then(response => {bookmarks = response;});"
          @boxsaved="fetchBoxes().then(response => boxes = response); showNewBoxModal = false"
          @newbox="showNewBoxModal = true">
        {{ $slot }}
        @include('boxes._create')
        @include('layouts._app-scripts')
    </main>
</div>
</body>
</html>
