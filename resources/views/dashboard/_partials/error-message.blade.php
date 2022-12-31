@if($errors->any())
    <div class="bg-red-500 tracking-widest text-white p-6 shadow-sm sm:rounded-lg mb-5">
        <ul>
        @foreach($errors->all() as $error)
            <li class="list-item"> {{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
