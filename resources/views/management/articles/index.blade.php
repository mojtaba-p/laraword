<x-app-layout class="bg-gray-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>

    <div class="dashboard-container" x-data="{showModal:false, article:''}">
        @include('dashboard._partials.messages')

        @include('dashboard.articles._actions', ['action_path' => route('management.articles.index')])
        @foreach ($articles as $article)
            <div class="mb-2">
                <div class="dashboard-white-item flex flex-row items-center">
                    <div class="p-6 md:w-7/12">
                        <a href="{{ route('dashboard.articles.edit', $article) }}">
                            {{ $article->title }}
                            <span class="text-gray-200">|</span>
                            <a href="{{ '/@'.$article->author->username }}"
                               class="text-gray-600 text-xs">
                                by {{ $article->author->name }}
                            </a>

                            <span class="text-gray-500 italic">{{ $article->status == 0 ? __('(draft)') : '' }}</span>
                        </a>
                    </div>
                    <div class="md:w-1/24 p-3 mx-3 flex flex-row rounded-xl space-x-2">
                        <a href="{{ route('articles.show', $article) }}">
                            <x-svg.tr-arrow class="w-3.5"/>
                        </a>

                    </div>
                    <div class="md:w-1/24 p-2 mx-3  flex flex-row items-start">
                        <x-svg.thumb-up class="w-4"/>
                        <span class="text-xs">{{ $article->likes_count }}</span>
                    </div>
                    <div class="md:w-1/24 p-2 mx-3 flex flex-row items-start">
                        <x-svg.chat class="w-4"/>
                        <span class="text-xs">{{ $article->comments_count }}</span>
                    </div>
                    <div>
                        @if($article->thumbnail)
                            <img src="{{ asset($article->thumbnailPath(256)) }}" alt="" class="w-14">
                        @endif
                    </div>

                    <div class="ml-auto p-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <x-svg.horizontal-dots class="w-4"/>
                            </x-slot>
                            <x-slot name="content" class="p-2">
                                <form action="{{ route('dashboard.articles.pin', $article) }}" method="post">
                                    @csrf
                                    <button class="w-full text-left drop-down-item">
                                        {{ __('Mark as pinned') }}
                                    </button>
                                </form>
                                <div>
                                    <button class="w-full text-left drop-down-item"
                                            @click.prevent="showModal=true;article=`{{ $article->slug }}`"
                                    >{{ __('Add to collection') }}
                                    </button>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $articles->appends($_GET)->links() }}
        @include('dashboard.articles._add-to-collection-modal')

    </div>


</x-app-layout>
