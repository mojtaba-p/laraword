@section('title', $title )
<x-main-layout>
    <x-container-fluid>
        <div class="bg-white p-6 rounded shadow-xl my-10">
            <h2 class="text-xl font-bold mb-5">{{ $title }}</h2>
            <hr>
            <p class="mt-5">{{ $content }}</p>
        </div>
    </x-container-fluid>
</x-main-layout>
