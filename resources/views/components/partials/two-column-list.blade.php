@props(['articles'])
{{-- Editor's pick --}}
<div class="mb-6">
    <x-partials.line />
    <h2 class="my-5 font-bold text-xl">
        {{ $title }}
    </h2>
</div>

<div class="flex flex-wrap">
    @foreach($articles as $article)
    <div class="md:w-1/2 flex flex-row space-x-5 mb-5 relative">
        @if($article->thumbnail != null)
            <div class="w-1/3 max-h-28 overflow-hidden ">
                <a href="{{ route('articles.show', $article) }}">
                    <x-partials.thumbnail-img size="256" :article="$article" />
                </a>
            </div>
        @endif
        <div class="{{ $article->thumbnail ? 'w-2/3' : 'w-full' }}">
            <div class="details mb-2 flex flex-wrap space-x-4 text-gray-400 text-sm">
                <span>{{ $article->articleDate() }}</span>
                <span>{{ $article->readingTime().' '.__('min read') }}</span>
                @isset($article->category_id)
                    <a href="{{ route('categories.show', $article->category) }}"
                       class="hidden bg-gray-100 px-2 rounded-lg hover:bg-gray-300
                    transition-all md:inline">{{ $article->category->name }}</a>
                @endisset
            </div>
            <a href="{{ route('articles.show', $article) }}">
                <h3 class="font-bold text-xl">{{ $article->title }}</h3>
            </a>
        </div>
    </div>
    @endforeach
</div>

