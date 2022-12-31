@props(['items'])
<div class="mb-6">
    <x-partials.line color-width="3" />

    <h2 class="my-5 font-bold text-xl">
        {{ $title }}
    </h2>
    <div class="flex flex-wrap">
        @foreach($items as $topic)
        <a href="{{ route('tags.show', $topic->slug) }}"
           class="px-2 bg-gray-100 hover:bg-gray-300 rounded-md border-2 mr-3 mb-3">{{ $topic->name }}</a>
        @endforeach
    </div>
</div>
