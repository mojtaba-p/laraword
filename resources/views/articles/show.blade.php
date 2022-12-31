@if($top_notification)
    <div class="bg-red-300 p-2  text-center">{!! $top_notification  !!}</div>
@endif
@section('title', $article->getTitle())
@section('header')
    <meta name="title" content="{{ $article->getTitle() }}">
    <meta name="description" content="{{ $article->getDescription() }}">
@endsection
<x-main-layout>
    <x-container-fluid class="px-5 md:px-0">
        <header>
            @include('articles.show._header')
        </header>
        <main x-data="{ show_comments: false }">
            <article class="mt-10">
                <h2 class="text-3xl font-black my-3" id="article-title">
                    {{ $article->title }}
                </h2>
                @if($article->thumbnail)
                    <div class="my-5" id="article-picture">
                        <img src="{{ asset($article->thumbnailPath()) }}" alt="writer" class="max-w-full mx-auto">
                    </div>
                @endif
                <div id="article-content" class="ck-content prose prose-slate max-w-full">
                    {!! $article->content !!}
                </div>

                @if(count($article->tags))
                    <div id="article-tags" class="mt-5">
                        <span>tags:</span>
                        @foreach($article->tags as $tag)
                            <a href="{{ route('tags.show', $tag) }}"
                               class="px-2 bg-gray-100 hover:bg-gray-300 rounded-md border-2 mb-3">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                @endif

            </article>

            @include('articles.show._actions')
            @include('articles.show._author-info')
            @include('articles.show._comments-section')
            @include('articles.show._like-script')
            @include('articles.show._related')

        </main>
    </x-container-fluid>
</x-main-layout>

