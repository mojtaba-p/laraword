@if(count(allTopics()) < 1)
    <div class="flex flex-col bg-white p-6 rounded-lg w-full text-center">
        <h4 class="block text-xl">
            {{ __("It seems you are the first guy who will create first topic.") }}
        </h4>
        <h5 class="text-lg">{{ __("because there aren't any topic to follow yet! you must be patient or create an article with some tag") }}</h5>
        <div class="mx-auto md:ml-auto block mt-5">
            <a href="{{ route('dashboard.articles.create') }}" class="primary-create-btn">{{ __('Write an Article') }}</a>
        </div>
    </div>
@else
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col" x-data="{models:[]}">
        <div class="block w-full text-lg font-bold mb-2">
            <h2>{{ __('Select your interested topics') }}:</h2>
        </div>
        <form action="{{ route('follow.store.interest') }}" method="post">
            @csrf
            <div class="w-full flex flex-wrap">
                @foreach(allTopics() as $topic)
                    <label for="{{ $topic->slug }}">
                        <input id="{{ $topic->slug }}" type="checkbox"
                               name="interested_topics[]"
                               value="{{ $topic->slug }}"
                               x-model="models['{{ $topic->slug }}']"
                               class="hidden">
                        <div class="py-1 px-2 m-2 bg-gray-100 inline-block rounded-lg"
                             :class="{'bg-blue-600 text-white' : models['{{ $topic->slug }}']}">

                            {{ $topic->name }}
                        </div>
                    </label>
                @endforeach
            </div>
            <div class="w-full mt-2">
                <button class="primary-indigo-btn">{{ __('Start Following') }}</button>
            </div>
        </form>
    </div>
@endif
