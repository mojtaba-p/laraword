@props(['articles', 'user_bookmarks'])
<div class="mb-6">
    <x-partials.line color-width="6"/>
    <h2 class="my-5 font-bold text-xl">
        {{ $title }}
    </h2>
</div>

<div class="flex flex-wrap">
    @foreach($articles as $article)
        <div class="flex flex-row space-x-5 mb-5 shadow-sm p-3">
            @if($article->thumbnail != null)
                <div class="img w-1/3 max-h-56 overflow-hidden shadow-xl">
                    <x-partials.thumbnail-img size="256" :article="$article" />
                </div>
            @endif
            <div class=" {{ $article->thumbnail ? 'w-2/3' : 'w-full' }} p-2">
                <div class="details mb-2 flex flex-wrap space-x-4 text-gray-400 text-sm items-center">
                    <div class="flex flex-row items-center">
                        <x-user-photo :user="$article->author" class="w-5 h-5"/>
                        <a href="{{ $article->author->profileLink() }}"
                           class="text-black">{{ $article->author->name }}</a>
                    </div>
                    <span>{{ $article->articleDate() }}</span>
                    <span>{{ $article->readingTime().' '.__('min read') }} </span>

                </div>
                <a href="{{ route('articles.show', $article) }}">
                    <h3 class="font-bold text-base md:text-xl">
                        {{ $article->title }}
                    </h3>
                    <p class="hidden md:block text-gray-500">{{ $article->contentSummary(isset($article->thumnail) ? 160 : 256) }}</p>

                </a>
                <div class="details-down mt-2 flex flex-row items-center">

                    @isset($article->category_id)
                        <a href="{{ route('categories.show', $article->category) }}"
                           class="hidden bg-gray-100 px-2 rounded-lg hover:bg-gray-300
                    transition-all md:inline">{{ $article->category->name }}</a>
                    @endisset
                    <div class="flex flex-row items-start ml-2">
                        <x-svg.chat class="w-4"/>
                        <small class="leading-none ml-0.5">{{ $article->comments_count }}</small>
                    </div>
                    @if(auth()->check())
                        <x-bookmark class="ml-2"
                                    :article="$article"
                                    :isBookmarked="in_array($article->id, [])" />
                    @else
                        <x-bookmark class="ml-2" isBookmarked="false"/>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

