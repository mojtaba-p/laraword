@props(['user'])
@isset($user->photo)
    <img loading="lazy" src="{{ asset($user->getPhotoPath()) }}" alt="{{ $user->name }}'s Photo" {{ $attributes }} />
@else
    <img loading="lazy"  src="{{ asset('/profiles/default.jpg') }}" alt="{{ $user->name }}'s Photo" {{ $attributes }} />
@endif
