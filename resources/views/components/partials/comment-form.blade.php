@props(['article'])

<form action="{{ route('articles.comments.store', $article) }}" method="post" {{ $attributes->merge(['class' => 'w-full flex flex-row items-end']) }}>
    @csrf
    {{ $slot }}
    <textarea name="body" class="md:w-5/6 rounded-md py-2" rows="1" placeholder="write your comment..."></textarea>
    <button
        class="bg-blue-700 rounded py-2 -mt-2 px-4 mx-auto text-sm text-white font-black">{{ $attributes->get('btn-text', 'submit') }}</button>
</form>
