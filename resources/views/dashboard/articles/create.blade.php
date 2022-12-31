<x-paper-layout class="bg-gray-100" x-data="{  options_dialog: false }" x-cloak>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('dashboard.articles.store') }}"
                  id="articleForm"
                  x-ref="form"
                  method="POST" enctype="multipart/form-data">
                @csrf
                <x-articles.form-fields :article="new \App\Models\Article()" :categories="$categories">
                    <x-slot:submit_button>
                        <button type="submit" class="primary-green-btn w-full"
                                @click="document.querySelector('#FSB').click()">Save Article</button>
                    </x-slot:submit_button>
                </x-articles.form-fields>

            </form>
        </div>
    </div>
</x-paper-layout>
