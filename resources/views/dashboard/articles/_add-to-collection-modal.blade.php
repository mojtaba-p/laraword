<div class="collection-modal fixed w-full h-full left-0 top-0" x-show.transition.opacity.duration.700ms="showModal" x-cloak>
    <div class="w-6/12 h-56 bg-white rounded-md shadow-md absolute m-auto left-0 right-0 top-1/3 z-50 p-6">
        <p class="text-lg font-bold">Add Article to a collection</p>
        <form action="{{ route('management.collections.add') }}" class="flex flex-wrap mt-5" method="post">
            @csrf
            <input type="hidden" name="article" :value="article">
            <label for="collection" class="text-sm mb-2">Collection:</label>
            <select name="collection" id="collection" class="w-full rounded-md ring-gray-300" required>
                <option>Please select a collection</option>
                @foreach($collections as $slug => $name)
                    <option value="{{ $slug }}">{{ $name }}</option>
                @endforeach
            </select>
            <button type="submit" class="primary-create-btn mt-3 mx-auto">Add to collection</button>
        </form>
    </div>
    <div class="bg-black w-full h-full z-40 opacity-25 top-0 left-0 backdrop-blur-3xl" @click="showModal=false"></div>
</div>
