<div class="flex flex-col-reverse md:flex-row items-center mb-5">

    @if(request('date') == null && $articles->count() < 1)
        <div>
            {{ __("You don't have any articles, write one.") }}
        </div>
    @endif

    <div class="flex flex-row items-center">
        <x-dropdown width="64" align="left" hasInput="true">
            <x-slot name="trigger">
                <button class="primary-indigo-btn md:ml-2 my-2 md:my-0 flex items-center">{{ __('Filter') }}</button>
            </x-slot>
            <x-slot name="content">
                <form action="{{ $action_path ?? route('dashboard.articles.index') }}" method="get">
                    <div class="py-2 px-4">
                        <div>
                            <label for="order" class="hidden md:inline-block">{{ __('Sort') }}:</label>
                            <select name="order" id="order" class="primary-input">
                                @foreach(\App\Models\Article::orderOptions() as $value => $name)
                                    @isset($_GET['order'])
                                        <option
                                            value="{{ $value }}" @selected($_GET['order'] == $value)>{{ $name }}</option>
                                    @else
                                        <option value="{{ $value }}">{{ $name }}</option>
                                    @endisset
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name="sort" id="sort" class="primary-input">
                                @php( $_GET['sort'] = $_GET['sort'] ?? 'desc')
                                <option value="desc" @selected($_GET['sort'] == 'desc')>{{ __('Descending')  }}</option>
                                <option value="asc" @selected($_GET['sort'] == 'asc')>{{ __('Assending')  }}</option>
                            </select>
                        </div>

                        <details class="mt-4">
                            <summary class="filter-summary">
                                {{ __('Date') }}
                            </summary>

                            <select name="date" id="date" class="primary-input w-full">
                                @php( $_GET['date'] = $_GET['date'] ?? 'all')
                                <option value="all" @selected($_GET['date'] == 'all')>{{ __('All time') }}</option>
                                <option value="today" @selected($_GET['date'] == 'today')>{{ __('Today') }}</option>
                                <option value="last_week" @selected($_GET['date'] == 'last_week')>{{ __('Last Week') }}</option>
                                <option value="last_month" @selected($_GET['date'] == 'last_month')>{{ __('Last Month') }}
                                </option>
                            </select>
                        </details>
                        <details class="mt-4">
                            <summary class="filter-summary">
                                {{ __('Title') }}
                            </summary>

                            <x-text-input id="title" class="block mt-1 w-full" type="text"
                                          placeholder="{{ __('title') }}"
                                          name="title" :value="old('title', request()->title)"/>
                        </details>
                        @if(request()->routeIs('management.*'))
                            <details class="mt-4">
                                <summary class="filter-summary">
                                    {{ __('Author Username') }}
                                </summary>

                                <x-text-input id="username" class="block mt-1 w-full" type="text"
                                              placeholder="{{ __('username') }}"
                                              name="username" :value="old('username',  request()->username)"/>
                            </details>
                        @endif

                        <details class="mt-4">
                            <summary class="filter-summary">
                                {{ __('Category') }}
                            </summary>

                            <x-category-select :categories="$categories"
                                               :selected=" $_GET['category_id'] ?? ''"/>
                        </details>
                        <details class="mt-4">
                            <summary class="filter-summary">
                                {{ __('Tags') }}
                            </summary>

                            <x-text-input id="tags" class="block mt-1 w-full " type="text"
                                          placeholder="tag1, tag2, tag3"
                                          name="tags" :value="old('tags', request()->tags)"/>
                        </details>
                        <button class="primary-green-btn mt-2">{{ __('Filter') }}</button>
                    </div>
                </form>

            </x-slot>
        </x-dropdown>

        @if(request('date') != null)
            <a href="{{ url()->current() }}" class="ml-4 primary-indigo-btn-outline">{{ __('Clear Filters') }}</a>
        @endif
    </div>

    <div class="mx-auto md:ml-auto md:mr-0">
        <a href="{{ route('dashboard.articles.create') }}" class="primary-create-btn">{{ __('Write an Article') }}</a>
    </div>
</div>

