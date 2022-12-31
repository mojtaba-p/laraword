@props(['user'])
@if($user->social != null)
    @foreach($user->social as $social => $id)
        @if(in_array($social, ['twitter', 'instagram', 'github']) && isset($id))
            <a href="http://{{ $social }}.com/{{ $id }}" class="hover:fill-black">
                <x-dynamic-component :component="'svg.'.$social" class="w-4 h-4"/>
            </a>
        @endif
        @if($social == 'linkedin')
            <a href="http://{{ $social }}.com/in/{{ $id }}" class="hover:fill-black">
                <x-svg.linkedin class="w-4 h-4"/>
            </a>
        @endif
    @endforeach
@endif
