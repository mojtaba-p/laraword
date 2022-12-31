@props(['article'])
@if(auth()->check())
    <div {{ $attributes->merge(['class' => 'relative bookmarkContainer']) }}
         x-data="{ bookmarked: false , open: false }" @click.outside="open = false"
         x-effect="bookmarked = bookmarks.includes(@js($article->slug))">
        <x-dropdown :hasInput="true" width="64" align="left">
            <x-slot name="trigger">
                <button @click="refreshBoxes($el, @js(route('dashboard.articles.bookmark.boxes', $article)))" class="bookmarkBtn">
                    <img :src="bookmarked ? '{{ asset('/assets/bookmark-filled.svg') }}'
                                          : '{{ asset('/assets/bookmark.svg') }}'" class="w-4 h-4">
                </button>
            </x-slot>
            <x-slot name="content">
                <div class="p-6 flex flex-col">
                    <form action="{{ route('dashboard.articles.bookmark.store', $article) }}" x-data="{ selectedBoxes:[], syncing: false }">
                        <div x-show="!syncing">
                            <template x-for="box in boxes">
                                <div class="flex flex-row items-center my-2" x-data="{ id: $id(box.slug) }">
                                    <label :for="id" class="flex flex-row items-center">
                                        <input type="checkbox" :id="id" x-model="selectedBoxes"
                                               @click="boxSelected($el.closest('form'), @js(route('dashboard.articles.bookmark.store', $article)) )"
                                               :value="box.slug" class="mr-0.5">
                                        <span x-text="box.name"></span>
                                    </label>
                                    <img src="{{ asset('/assets/lock-closed.svg') }}" class="h-3 ml-auto"
                                         x-show="box.private">
                                </div>
                            </template>
                        </div>
                        <div x-show="syncing" class="cursor-progress">
                            <x-svg.spinner class="w-1/2 mx-auto fill-black animate-spin"/>
                        </div>
                    </form>
                </div>
                <div class="w-full border-t-2">
                    <button class="primary-indigo-btn-outline block mx-auto mt-2"
                            @click="$dispatch('newbox')">
                        {{ __('Create New Box') }}
                    </button>
                </div>
            </x-slot>
        </x-dropdown>
    </div>
@else
    <div {{ $attributes }} >
        <a href="/login?redirect={{ url()->current() }}">
            <img src="{{ asset('/assets/bookmark.svg') }}" class="w-4 h-4">
        </a>
    </div>
@endif
