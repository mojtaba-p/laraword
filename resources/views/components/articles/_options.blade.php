<div class="w-8/12 mx-auto space-y-2 space-x-3 m-5 flex flex-row ">
    <div class="w-6/12">

        <div class="block mb-3">
            <div class="flex flex-col items-start space-y-5">
                <div class="w-full">
                    <label for="tags">Tags <span class="text-xs">(topics)</span></label>
                    <input type="text" class="mt-1 block w-full rounded-md" name="tags"
                           value="{{ old('tags', implode(', ', $article->tags->pluck('name')->all() )) }}">
                    <p class="mt-2 text-sm text-gray-500">
                        Separate tags with commas(","):
                        <span class="text-xs">
                            some tag, other tag, ...
                        </span>
                    </p>

                    <x-input-error :messages="$errors->get('tags')"
                                   class="mt-2 border-2 border-red-500 p-2 rounded-md"/>

                </div>

                <div class="w-full">
                    <label for="tags">Meta Title <span class="text-sm text-gray-600 italic">SEO Title</span></label>
                    <input type="text" class="mt-1 block w-full rounded-md" name="meta_title"
                           value="{{ old('meta_title', $article->meta_title) }}">
                    <p class="mt-2 text-xs text-gray-500">
                        by default: article title | by author
                    </p>

                    <x-input-error :messages="$errors->get('meta_title')"
                                   class="mt-2 border-2 border-red-500 p-2 rounded-md"/>
                </div>
                <div class="w-full">
                    <label for="meta_description">
                        Meta Description <span class="text-sm text-gray-600 italic">SEO Description</span>
                    </label>
                    <textarea class="mt-1 block w-full rounded-md" id="meta_description" name="meta_description"
                    >{{ old('meta_description', $article->meta_description) }}</textarea>

                    <p class="mt-2 text-xs text-gray-500">
                        by default: first 160 characters of content
                    </p>

                    <x-input-error :messages="$errors->get('meta_title')"
                                   class="mt-2 border-2 border-red-500 p-2 rounded-md"/>
                </div>

            </div>
        </div>
        <div class="save">
            <button class="primary-create-btn" @click.prevent="options_dialog = false">Close</button>
        </div>
    </div>
    <div class="w-6/12 flex flex-col">
        <div class="block mb-3" x-data="thumbnailData()">
            <label for="thumbnail">Thumbnail</label>
            <img :src=image x-show="image.length" class="border-2"
                 @click="$refs.imginput.click()"
            />
            <div class="w-full h-36 border-2"
                 x-show="!image"
                 @click="$refs.imginput.click()"
                 style="background: url('/assets/media-bg.png') center no-repeat; background-size: 100px"
            ></div>
            <input type="file" name="thumbnail" id="thumbnail" accept="jpg,jpeg,png"
                   x-ref="imginput"
                   @change="changeThumbnail($event.target.files[0])"
                   class="file-upload hidden">
            <script>
                function thumbnailData() {
                    return {
                        image: '{{ isset($article->thumbnail) ? asset(auth()->user()->mediaPath($article->thumbnail)) : '' }}',
                        img_note: '',
                        changeThumbnail(file) {
                            if ((file.size / 1024) > 1024) {
                                alert('Selected file is big. selected file must less than 1024 kilobytes.');
                                return;
                            }
                            img_note = 'Thumbnail will upload when you save or update article';
                            this.image = URL.createObjectURL(event.target.files[0]);
                        }
                    }
                }
            </script>
            <span class="text-blue-600 text-xs" x-text="img_note"></span>
            <x-input-error :messages="$errors->get('thumbnail')"
                           class="mt-2 border-2 border-red-500 p-2 rounded-md"/>

        </div>
        <div class="w-full">
            <label for="category">Category</label>
            <x-category-select :categories="$categories" :selected="$article->category_id" />

            <x-input-error :messages="$errors->get('category_id')"
                           class="mt-2 border-2 border-red-500 p-2 rounded-md"/>

        </div>
    </div>

</div>
