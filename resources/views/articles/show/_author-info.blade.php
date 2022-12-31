<div class="flex flex-col my-10 border p-6 bg-violet-50" id="author-info">
    <div class="flex flex-row items-center">
        <div id="author-image" class="w-3/12 md:w-1/12">

            <x-user-photo :user="$article->author" class="rounded-full" />
        </div>
        <div class="flex flex-col mx-5 w-11/12">
            <div id="author-name" class="text-lg font-bold">
                <a href="{{ route('users.profile',  $article->author) }}">
                    {{ $article->author->name }}
                </a>
            </div>
            <div id="author-links" class="flex flex-row fill-gray-500 space-x-4">
                <x-social-link-icons :user="$article->author" />
            </div>
        </div>
    </div>
    <div id="author-about">
        <div class="mt-4">
            {{ $article->author->bio }}
        </div>
    </div>
</div>
