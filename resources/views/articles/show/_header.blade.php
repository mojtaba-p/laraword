<div class="flex flex-wrap items-center justify-between">
    <div id="article-detail" class="w-3/6 flex flex-row items-center">
        <x-user-photo :user="$article->author" class="rounded-full w-14" />
        <div class="article-details mx-3">
            <div class="flex flex-col">
                <strong class="text-lg">
                    <a href="{{ route('users.profile',  $article->author) }}">{{ $article->author->name }}</a>
                </strong>
                <div class="divide-x divide-gray-200 -mx-3 text-gray-400">
                                <span class="px-3">
                                    {{ $article->articleDate() }}
                                </span>
                    <span class="px-3">{{ $article->readingTime() }} min read</span>
                </div>
            </div>
        </div>
    </div>
    @can('edit', $article)
        <a href="{{ route('dashboard.articles.edit', $article) }}"
           class="bg-cyan-300 px-2 py-1 ring-1 rounded ml-auto mr-2">Edit</a>
    @endcan
    <div class="w-1/6">
        @if($article->category_id)
            <div class="text-gray" id="article-category">
                <a href="{{ route('categories.show', $article->category) }}"
                   class="px-2 bg-gray-100 hover:bg-gray-300 rounded-md border-2 mr-3 mb-3">
                    {{ strtoupper($article->category->name) }}
                </a>
            </div>
        @endif
    </div>
</div>
