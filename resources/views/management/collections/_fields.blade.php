<div class="flex flex-row space-x-2">
    <div class="   w-1/3 ml-auto">
        <div class="w-full p-6 bg-white border-b border-gray-200 rounded-md shadow-sm">
            <x-input-label for="name" :value="__('Collction Name')"/>

            <x-text-input id="name" class="block mt-1 w-full p-2" type="text" name="name"
                          :value="old('name', $collection->name)" required autofocus/>

            <x-input-error :messages="$errors->get('Name')" class="mt-2"/>
        </div>

    </div>

    <div class="flex flex-col  p-6 border-b border-gray-200 rounded-md shadow-sm w-2/3 bg-gray-200">
        <h2 class="font-bold">Collection items</h2>
        <hr>

        <x-input-error :messages="$errors->get('articles[]')" class="mt-2"/>

        <div class="article-collection" x-data="select2similar()">

            <div class="article-search-input relative">
                <x-text-input id="name" class="block mt-1 w-full p-2" type="text" @input.debounce.500ms="search();"
                              x-model="searchText" @keyup.enter="search()" autocomplete="off" @blur="showItems=false"
                              @focus="showItems=true"/>
                <div class="search-results absolute bg-white w-full p-2 shadow-md rounded-b-2xl"
                     x-show="showItems" x-transition>
                    <div class="flex flex-col space-y-2 max-h-48 overflow-auto">
                        <template x-for="item in searchResults">
                            <div class="p-2 w-full hover:bg-gray-100 rounded-md flex flex-row">
                                <div class="w-9/12">
                                    <span x-text="item.title"></span>
                                    <span x-text="`(${item.author})`" class="text-sm text-gray-600"></span>
                                </div>
                                <div class="w-3/12 ">

                                    <button class="px-2 py-1 bg-green-600 hover:bg-green-800 ml-auto
                                     text-xs text-white rounded" @click.prevent="select(item)">SELECT
                                    </button>
                                    <a :href="item.url" class="px-2 py-1 bg-black hover:bg-gray-800
                                     text-xs text-white rounded" target="_blank">OPEN</a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>


            <div class="flex flex-wrap collection-items my-2">
                <template x-for="item in selectedItems">
                    <div
                        class="bg-white m-2 shadow-sm rounded-lg pr-0 h-fit overflow-hidden flex flex-row items-center">
                        <input type="hidden" name="articles[]" :value="item.slug">
                        <input type="hidden" name="article_item[]" :value="item">
                        <a class="p-2" :href="`/articles/${item.slug}`" x-text="item.title" target="_blank"></a>
                        <button class="px-2 py-1 text-gray-500 text-xs border-l hover:bg-gray-300"
                                @click.prevent="deleteItem(item.slug)">X
                        </button>
                    </div>
                </template>
            </div>

        </div>
    </div>
</div>
<script>
    document.addEventListener('alpine:init', function () {
        Alpine.data('select2similar', function () {
            return {
                searchText: '',
                searchResults: [],
                selectedItems: {!! $init_value ?? '[]'  !!},
                showItems: false,

                search() {
                    if (this.searchText.length > 2) {
                        fetch('/articles/by-title/' + this.searchText, {
                            headers: {'Accept': 'application/json'}
                        })
                            .then(response => response.json()
                                .then(result => this.searchResults = result.data.filter(
                                        (item) => this.selectedItems.map((sitm) => sitm.slug === item.slug)
                                            .filter(res => res == true).length < 1
                                    )
                                )
                            )
                    } else {
                        this.searchResults = []
                    }
                },
                select(item) {
                    this.selectedItems.push(item)
                    this.searchResults = this.searchResults.filter((searchItem) => searchItem.slug !== item.slug)
                },
                deleteItem(deletedItem) {
                    this.selectedItems = this.selectedItems.filter(function (selectedItem) {
                        return selectedItem.slug != deletedItem
                    })
                }
            }
        })
    })

</script>
