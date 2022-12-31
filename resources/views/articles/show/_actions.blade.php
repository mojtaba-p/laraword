<div id="article-actions" class="flex flex-row my-10  w-1/6 mx-auto text-sm"
     x-data="{ likes : {{ $article->likes_count }} }">
    @auth()
        <a href="#" id="Like-btn"
           @click.prevent="like('article','{{$article->slug}}').then(res=>likes=res)"
           class="border p-3 mx-3 bg-purple-50 hover:bg-purple-500 hover:text-white flex flex-row rounded-xl space-x-2">
            <x-svg.thumb-up class="w-4"/>
            <span x-text="likes"></span>
        </a>
    @else
        <a href="{{ route('login') }}?redirect_to={{ route('articles.show', $article) }}" id="Like-btn"
           class="border p-3 mx-3 bg-purple-50 hover:bg-purple-500 hover:text-white flex flex-row rounded-xl space-x-2">
            <x-svg.thumb-up class="h-4 w-4"/>
            <span x-text="likes"></span>
        </a>
    @endauth

    <a href="#comments" id="Comment-btn"
       @click="show_comments = !show_comments;"
       class="border p-3 mx-3 bg-purple-50 hover:bg-purple-500 hover:text-white rounded-xl flex flex-row rounded-xl space-x-2">
        <x-svg.chat class="w-4"/>
        <span>{{ $article->comments_count }}</span>
    </a>
</div>
