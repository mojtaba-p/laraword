<x-paper-layout class="bg-gray-100" x-data="{  options_dialog: false }" x-cloak>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" x-data="{content: ''}">
            <form action="{{ route('dashboard.articles.update', $article) }}" method="POST"
                  id="articleForm"
                  x-ref="form"
                  enctype="multipart/form-data">
                @csrf
                @method('put')
                <x-articles.form-fields :article="$article" :categories="$categories">
                    <x-slot:submit_button>
                        <button type="submit" class="primary-green-btn w-full"
                                @click="event.preventDefault();
                                $refs.content.value=editor.getData();
                                $refs.form.submit();">Update</button>

                    </x-slot:submit_button>
                </x-articles.form-fields>
            </form>
        </div>
    </div>
</x-paper-layout>

