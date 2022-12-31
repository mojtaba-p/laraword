<div class="flex flex-col w-full md:w-2/3 border rounded-lg mx-auto mb-5 py-5" id="comments"
     x-data="{ open_root: true }">
    <h4 class="font-black text-xl mx-7">Comments</h4>
    @if(session()->has('comment.success'))
        <div class="w-full p-5 bg-green-300 font-bold">
            {{ __('comment.success') }}
        </div>
    @endif
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="w-full p-5 bg-red-300 font-bold">
                {{ $error }}
            </div>
        @endforeach
    @endif
    @guest
        <span class="text-center">Please
                    <a href="{{ route('login') }}?redirect_to={{ route('articles.show', $article) }}#comments"
                       class="inline-block">
                         Login
                    </a>
                    to write comment.</span>
    @else
        <x-partials.comment-form btn-text="submit" :article="$article" class="px-3 mt-5 border-b-2 pb-5"/>

    @endguest
    @if(isset($comments['root']))
        <button @click="show_comments = true" x-show="! show_comments" class="my-4">
            View Comments
        </button>
        <button @click="show_comments = false" x-show="show_comments" class="my-4">
            Hide Comments
        </button>

        <div class="comments-list" x-show="show_comments" x-transition>

            @foreach($comments['root'] as $comment)
                @include('components.partials.comment', ['add_class' => 'border-b-2', 'parent' => 'root', 'open' => 'false'])
            @endforeach

        </div>
    @endif
</div>
