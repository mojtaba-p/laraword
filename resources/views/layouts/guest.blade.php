<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts._head')

<body {{ $attributes->merge(['class' => 'font-serif antialiased']) }}>
@include('layouts.guest-navigation')

<div class="font-serif text-gray-900 antialiased">
    {{ $slot }}
</div>
</body>
</html>
