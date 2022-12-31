<div class="flex flex-col mt-4 mx-5 py-4 {{ $add_class }}"
     x-data="{ open_{{ $comment->id }}: {{ $open }}, reply_{{ $comment->id }} : false }"
     {{-- specifies comment replies and reply form display --}}
     x-show="open_{{ $parent }}" {{-- specifies current comment display --}}
     x-transition {{-- transition display and hide for replies --}}
     id="comment-no-#{{ $comment->id }}">

    @php($main_comment_id = $comment->id)


    {{-- comment info includes: avatar, name, date --}}
    <div class="comment-info flex flex-row items-center">
{{--        <img src="https://picsum.photos/id/{{ rand(50,100) }}/100/100" alt="writer" class="rounded-full w-1/12">--}}
        <div class="comment-details mx-3">
            <strong class="text-lg">{{ $comment->writer->name }}</strong> <span
                class="mx-1 text-gray-300 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
        </div>
    </div>

    {{-- comment main content --}}
    <div class="comment-content my-1 p-4">{{ $comment->body }}</div>

    {{-- comment actions include: Like, Reply and display replies of others --}}
    <div class="comment-actions flex flex-row items-center" x-data="{likes: {{ $comment->likes_count }} }">



        @auth
            <a href="#" id="Like-btn-{{ $comment->id }}"
               @click.prevent="like('comment',{{$comment->id}}).then(res=>likes=res)"
               class="flex flex-row items-center space-x-2 border-r-2 pr-3">
                <x-svg.thumb-up class="h-4 w-4"/>
                <span class="text-sm" x-text="likes"></span>
            </a>

            <a href="#" class="text-sm font-bold pl-3"
               @click.prevent="reply_{{ $comment->id }} = ! reply_{{ $comment->id }}">
                Reply
            </a>
        @else
            <a href="{{ route('login') }}?redirect_to={{ route('articles.show', $article) }}#comments" id="Like-btn-{{ $comment->id }}"
               class="flex flex-row items-center space-x-2 border-r-2 pr-3">
                <x-svg.thumb-up class="h-4 w-4"/>
                <span class="text-sm" x-text="likes"></span>
            </a>

            <a href="{{ route('login') }}?redirect_to={{ route('articles.show', $article) }}#comments"
               class="text-sm font-bold pl-3">
                Reply
            </a>
        @endauth

        @if(isset($comments[$comment->id]))
            <div class="replies ml-auto pr-5 text-xs">
                <button @click="open_{{ $comment->id }} = ! open_{{ $comment->id }}" x-show="! open_{{ $comment->id }}">
                    ({{ count($comments[$comment->id]) }}) View Replies
                </button>
            </div>
        @endif
    </div>

    @auth
        {{-- Form for replying to comment --}}

        <div class="reply-form mt-2" x-show="reply_{{ $comment->id }}" x-transition>
            <x-partials.comment-form btn-text="Reply" :article="$article">
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            </x-partials.comment-form>
        </div>
    @endauth

    {{-- if comment has any replies include them --}}
    @if(isset($comments[$comment->id]))
        @php($parent_id = $comment->id)
        @foreach($comments[$comment->id] as $comment)
            @include('components.partials.comment',
                    ['add_class' => 'bg-gray-50 pl-5 rounded-xl', 'parent' => $parent_id, 'open' => 'false'])
        @endforeach

    @endif

    {{-- hiding comment replies --}}
    <div class="replies ml-auto pr-5 text-xs mt-4" x-show="open_{{ $main_comment_id }}">
        <button @click="open_{{ $main_comment_id }} = ! open_{{ $main_comment_id }}">
            Hide Replies
        </button>
    </div>

</div>
