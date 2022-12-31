@if($related_articles->count() > 0)
    <div class="flex flex-col bg-indigo-50 p-6">
        <x-partials.two-column-list :articles="$related_articles">
            <x-slot:title>
                Related Articles
            </x-slot:title>
        </x-partials.two-column-list>
    </div>
@endif
