@props(['articles', 'topic'])
<x-container-fluid>
    <x-partials.one-column-list :articles="$articles">
        <x-slot:title>
            <span class="font-black">{{ strtoupper($topic->name) }}</span> related articles.
            @if($topic instanceof \App\Models\Tag)
                @if(auth()->check())
                    <form action="{{ route('follow.store.topic') }}" method="post" class="inline-block ml-auto">
                        @csrf
                        <input type="hidden" name="tag" value="{{ $topic->slug }}">
                        @if(auth()->user()->isFollowingTopic($topic))
                            <button class="primary-indigo-btn-outline mt-5 bg-white border-2 border-indigo-600">
                                Unfollow
                            </button>
                        @else
                            <button class="primary-indigo-btn mt-5 inline-block">Follow +</button>
                        @endif
                    </form>
                @endif
            @endif
        </x-slot:title>
    </x-partials.one-column-list>
    {{ $articles->links() }}
</x-container-fluid>
