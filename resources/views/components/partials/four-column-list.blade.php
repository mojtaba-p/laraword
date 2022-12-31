@props(['articles'])
<div class="mb-6">
    <div class="h-0.5 bg-gray-200 rounded overflow-hidden">
        <div class="w-1/6 h-full bg-indigo-500"></div>
    </div>
    <h2 class="my-5 font-bold text-xl">
        {{ $title }}
    </h2>
</div>

<div class="flex flex-wrap -mx-4">
    @foreach($articles as $article)
        <div class="p-4 md:w-1/3 sm:mb-0 mb-6">
            @if($article->thumbnail != null)
                <div class="h-44 overflow-hidden shadow-md">
                    <a href="{{ route('articles.show', $article) }}">
                        <x-partials.thumbnail-img size="256" :article="$article" class="mx-auto" />
                    </a>
                </div>
            @endif
            <h2 class="text-xl font-bold title-font text-gray-900 mt-5">
                <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
            </h2>
            <p class="text-base leading-relaxed mt-2">{{ $article->getDescription() }}</p>
        </div>
    @endforeach
</div>

