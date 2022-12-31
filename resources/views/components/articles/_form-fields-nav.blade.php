<div class="fixed top-0 left-0 z-10 w-full bg-white">
    <div class="flex justify-between h-16 items-center px-2 md:max-w-5xl mx-auto">
        <div class="flex items-center">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-600"/>
                </a>
            </div>

        </div>
        <div class="flex ml-auto text-gray-700 text-sm">
            <button class="p-2 underline" @click="event.preventDefault();
                                $refs.status.value = 'draft';
                                $refs.content.value=editor.getData();
                                $refs.form.submit();">
                {{ $article->status == 1 ? 'Switch to draft' : 'Save as draft' }}
            </button>
        </div>

        <div class="mx-2">
            @if($article->status == 1)
                {{ $submit_button }}
            @else
                <button type="submit" class="primary-green-btn w-full"
                        @click="event.preventDefault();
                                $refs.status.value = 'publish';
                                $refs.content.value=editor.getData();
                                $refs.form.submit();">Publish</button>
            @endif
        </div>

        <div class="flex" x-data="">
            <button @click.prevent="options_dialog = true">
                <x-svg.horizontal-dots class="w-6 h-6"/>
            </button>
        </div>


    </div>
</div>
