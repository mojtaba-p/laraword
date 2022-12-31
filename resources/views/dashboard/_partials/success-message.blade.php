@if(session()->exists('success_status'))
    <div class="bg-green-500 tracking-widest text-white p-6 shadow-sm sm:rounded-lg mb-5">
        {{ session('success_status') }}
    </div>
@endif
