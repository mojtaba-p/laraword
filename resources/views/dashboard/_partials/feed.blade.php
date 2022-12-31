<div class="w-full md:w-3/12 p-2">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <ul class="space-y-2">

                <li class="{{ (empty($_GET)) ? 'text-indigo-500 font-bold border-r-2' : '' }}">
                    <a href="/dashboard" class="w-full p-2 inline-block hover:bg-gray-100 transition"
                    >For you</a>
                </li>

                <li class="{{ isset($_GET['following']) ? 'text-indigo-500 font-bold border-r-2' : '' }}">
                    <a href="/dashboard?following" class="w-full p-2 inline-block hover:bg-gray-100 transition"
                    >Following</a>
                </li>
                <hr>
                @foreach($followed_topics as $topic)
                    <li class="{{ request('topic') == $topic->slug
                                                ? 'text-indigo-500 font-bold border-r-2' : '' }}">
                        <a href="/dashboard?topic={{ $topic->slug }}"
                           class="w-full p-2 inline-block hover:bg-gray-100 transition">{{ $topic->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="w-full md:w-9/12 p-2">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            @if($articles->count() < 1 && (!isset($_GET['topic'])))
                {{ __("You aren't follow any user yet") }}.
            @else
                <x-partials.one-column-list :articles="$articles">
                    <x-slot:title></x-slot:title>
                </x-partials.one-column-list>
                {{ $articles->appends($_GET)->links() }}
            @endif
        </div>
    </div>
</div>
