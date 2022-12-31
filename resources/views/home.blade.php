<x-main-layout>
    <div class="container mx-auto px-5 md:px-0" id="app">

        <x-container-fluid>
            <h1 class="font-black text-center text-6xl text-violet-600 my-8 md:text-left">
                {{ config('app.name', 'Laravel') }}
            </h1>

            @if(isset($pinned_article))
                <x-partials.hero :article="$pinned_article"/>
            @endif
        </x-container-fluid>

        <x-container-fluid>
            @if(isset($editors_pick['articles']))
                <x-partials.two-column-list :articles="$editors_pick['articles']">
                    <x-slot:title>
                        Editors Pick
                        <a class="text-sm text-gray-700 font-medium underline"
                           href="{{ route('collections.show', $editors_pick['collection']) }}">{{ __('All Articles') }}</a>
                    </x-slot:title>
                </x-partials.two-column-list>
            @endif
        </x-container-fluid>

        <x-container-fluid>
            @if(isset($editors_pick['articles']))
                <x-partials.featured-two-column-l :articles="$top_2022['articles']">
                    <x-slot:title>
                        Top 2022 Selected Articles
                        <a class="text-sm text-gray-700 font-medium underline"
                           href="{{ route('collections.show', $top_2022['collection']) }}">{{ __('All Articles') }}</a>

                    </x-slot:title>
                </x-partials.featured-two-column-l>
            @endif
        </x-container-fluid>

        <x-container-fluid>
            <div class="flex flex-wrap">
                <div class="w-full md:w-3/4 pr-4">
                    <x-partials.one-column-list :articles="$top_viewed_lw_articles">
                        <x-slot:title>
                            Top Viewed in Last Week
                        </x-slot:title>
                    </x-partials.one-column-list>
                </div>
                @if($discover_links->count() > 0)
                    <div class="w-full md:w-1/4">
                        <x-partials.link-items :items="$discover_links">
                            <x-slot:title>
                                Discover More
                            </x-slot:title>
                        </x-partials.link-items>
                    </div>
                @endif
            </div>
        </x-container-fluid>

        <x-container-fluid>
            <x-partials.four-column-list :articles="$new_articles">
                <x-slot:title>
                    New Articles
                </x-slot:title>
            </x-partials.four-column-list>
        </x-container-fluid>
    </div>

</x-main-layout>
