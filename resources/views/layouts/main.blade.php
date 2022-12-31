@guest
    <x-guest-layout>
        {{ $slot }}
        <x-footer></x-footer>

    </x-guest-layout>
@else
    <x-app-layout>
        {{ $slot }}
        <x-footer></x-footer>
    </x-app-layout>

@endguest
