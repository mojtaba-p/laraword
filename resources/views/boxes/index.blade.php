<x-main-layout>
    <x-container-fluid>
        <div class="flex flex-wrap line">
            @include('users._navigation')

            <div class="w-full md:w-3/4 pr-4">

                <div class="mb-5">Boxes of {{ $user->name }}</div>
                @foreach($boxes as $box)
                    @if(!$box->private || (auth()->check() && $box->user->is(auth()->user())) )
                        <div class="flex flex-row border-2 mb-2">
                            <div class="box-title p-5 w-8/12">
                                <a href="{{ route('users.boxes.show', [$user, $box])  }}">{{ $box->name }}</a>
                            </div>
                            <div class="box-preview w-44 h-44 ml-auto overflow-hidden bg-gray-50">
                                @php($counter = 0)
                                @foreach($box->bookmarks as $bookmark)
                                    @if($counter++ == 3)
                                        <div class="box-photo-item -mt-16 z-0"><x-application-logo /></div>
                                        @break
                                    @endif
                                    <div class="box-photo-item {{ $counter == 1 ? 'mt-5' : '-mt-16' }}" style="z-index: {{ 4-$counter }}">
                                        @if(isset($bookmark->article->thumbnail))
                                            <img src="{{ asset($bookmark->article->thumbnailPath(256)) }}" alt="{{ $bookmark->article->title }}">
                                        @else
                                            <x-application-logo />
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            @include('users._user-info')
        </div>
        {{ $boxes->links() }}
    </x-container-fluid>
</x-main-layout>
