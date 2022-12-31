@props(['article', 'size'])
<img loading="lazy" src="{{ asset($article->thumbnailPath($size)) }}" alt="{{ $article->getTitle() }}"
     {{ $attributes->merge(['class' => thumbnailTailwindClass( asset($article->thumbnailPath($size))).' mx-auto'  ]) }}

>
