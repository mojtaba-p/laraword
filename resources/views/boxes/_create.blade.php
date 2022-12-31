<x-modal :show="false" showVariable="showNewBoxModal" name="create-new-box" focusable>
    <div class="p-10">
        <div x-data="{saving: false, name: '', private: false, message:''}" class="flex flex-col space-y-5">
            <strong>{{ __('Create New Box') }}</strong>
            <div class="mt-2 p-2 bg-red-500" x-text="message" x-show="message.length > 1"></div>
            <div>
                <label for="box-name">{{ __('Box Name:') }}</label>
                <input type="text" name="name" class="primary-input" x-model="name"
                       placeholder="{{ __('type name here') }}" autofocus>
                <label for="box-is-private">
                    <input type="checkbox" name="private" x-model="private" id="box-is-private">
                    {{ __('Private Box') }}
                </label>
            </div>
            <button class="disabled:bg-blue-500 disabled:cursor-no-drop primary-create-btn mr-auto"
                    @click="saving = true;
                        save(name, private)
                            .then(response => {
                                if(response.success != undefined) {message = ''; name = ''; private: false; $dispatch('boxsaved') }
                                if(response.message != undefined) { message = response.message; }
                                saving=false
                            })" :disabled="saving">
                <x-svg.spin class="animate-spin" x-show="saving"/>
                <span x-show="!saving">{{ __('Create') }}</span>
            </button>
        </div>
    </div>
</x-modal>
