@props(['articles'])
<div class="mb-6">
    <x-partials.line color-width="6"/>
    <h2 class="my-5 font-bold text-xl">
        {{ $title }}
    </h2>
</div>
<div class="flex flex-col md:flex-row space-x-5 divide-x ">
    <div class="w-full md:w-7/12">
        <div class="w-full flex flex-col  mb-5 relative item">
            @if($articles->first()->thumbnail != null)
                <div class="w-full">
                    <a href="{{ route('articles.show',  $articles->first())  }}">
                        <x-partials.thumbnail-img size="" :article="$articles->first()"/>
                    </a>
                </div>
            @endif
            <div class="w-full flex flex-col space-y-2 mt-2">
                <div class="">
                    @isset($articles->first()->category_id)
                        <a href="{{ route('categories.show', $articles->first()->category) }}"
                        >{{ strtoupper($articles->first()->category->name) }}</a>
                    @endisset

                </div>
                <a href="{{ route('articles.show',  $articles->first())  }}">
                    <h3 class="font-bold text-xl">{{  $articles->first()->title }}</h3>
                    <p class="text-gray-500">{{ $articles->first()->getDescription() }}</p>
                </a>
                <div class="details flex flex-wrap space-x-4 text-gray-400 text-sm">
                    <span>{{  $articles->first()->articleDate()  }}</span>
                    <span>{{ $articles->first()->readingTime() }} min read</span>
                    <span>by {{ $articles->first()->author->name }}</span>
                </div>

            </div>
        </div>
    </div>
    <div class="w-full md:w-5/12 divide-y pl-2">

        @foreach($articles as $article)
            @if($loop->first)
                @continue
            @endif

            <div class="w-full flex flex-row space-x-2 {{ $loop->last ? 'pt-3' : 'pt-3 pb-3' }} relative">
                @if($article->thumbnail != null)
                    <div class="w-1/3 max-h-32 overflow-hidden">
                        <a href="{{ route('articles.show', $article) }}">
                            <x-partials.thumbnail-img size="256" :article="$article"/>
                        </a>
                    </div>
                @endif
                <div class="w-2/3">
                    <a href="{{ route('articles.show', $article) }}">
                        <h3 class="text-md font-bold">{{ $article->getTitle() }}</h3>
                    </a>
                </div>
            </div>

        @endforeach

    </div>
</div>
