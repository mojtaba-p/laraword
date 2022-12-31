<div class="min-h-96 border-t-4 mt-6 bg-gray-100">
    <x-container-fluid>
        <div class="flex flex-col">
            <div class="flex flex-col md:flex-row justify-between mt-5">
                @foreach(config('laraword.footer.sections') as $name => $values)
                    <div class="w-1/3 p-2">
                    <h4 class="font-black pb-3 mb-3 ">{{ $name }}</h4>
                        <ul>
                            @foreach($values as $value)
                                @if($value['type'] == 'link')
                                    <li><a href="{{ $value['value'] }}">{{ $value['name'] }}</a></li>
                                @elseif($value['type'] == 'text')
                                    <li><strong>{{ $value['name'] }}</strong> {{ $value['value'] }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="w-full my-5">
                {{ __('All Rights Reserved') }}
            </div>
        </div>
    </x-container-fluid>
</div>
