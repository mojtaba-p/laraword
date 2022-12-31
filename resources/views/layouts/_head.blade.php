<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title', config('app.name', 'Laravel'))   </title>

@yield('header')
    <!-- styles -->
@stack('head-styles')

    <!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('head-scripts')

</head>
