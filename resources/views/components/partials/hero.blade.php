@props(['article'])
@if(isset($article))
    <div class="flex flex-col md:flex-row items-start">
        @if(isset($article->thumbnail))
            <img loading="lazy" src="{{ asset($article->thumbnailPath(256)) }}" alt="{{ $article->getTitle() }}"
                 class="w-full md:w-1/2 shadow-md">
        @endif
        <div class="w-full md:w-1/2 p-5">
            <span class="text-gray-200">{{ $article->articleDate() }}</span>
            <h2 class="font-bold text-xl">
                <a href="{{ route('articles.show', $article) }}" title="{{ $article->title }}">{{ $article->title }}</a>
            </h2>
            <p class="mb-5 leading-7">
                {{ $article->getDescription() }}
            </p>
            <a href="{{ route('articles.show', $article) }}"
               class="primary-indigo-btn">Read more</a>
        </div>
    </div>
@else
    {{ __('Article Not Found') }}
@endif
