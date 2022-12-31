@section('title', 'Profile -')

<x-app-layout class="bg-gray-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @include('dashboard._partials.success-message')

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')"/>

                    {{-- profiles --}}
                    <form action="{{ route('dashboard.profiles.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-row items-start">
                            <div class="w-full 2/3">
                                <!-- Name -->
                                <div class="w-full mb-3" x-data="{ imgSrc:'{{ $user->photo != null ? asset('profiles/'.$user->photo) : asset('profiles/default.jpg?') }}', upload_note:false }">
                                    <x-input-label for="photo" :value="__('Avatar')"/>

                                    <div class="rounded-full ring-2 w-44 h-44 overflow-hidden mx-auto">
                                        <img
                                            :src="imgSrc"
                                            class="w-44"
                                            @click="$refs.photo.click()">
                                    </div>
                                    <input type="file" name="photo" class="hidden" accept="jpg,jpeg,png" x-ref="photo" @change="imgSrc = URL.createObjectURL($event.target.files[0]); upload_note = true">
                                    <div class="text-red-400 text-center" x-show="upload_note">Selected new photo will submit after you save and update profile.</div>
                                    <x-input-error :messages="$errors->get('photo')"
                                                   class="mt-2 border-2 border-red-500 p-2 rounded-md"/>
                                </div>

                                <div class="w-full">
                                    <x-input-label for="name" :value="__('Name')"/>

                                    <x-text-input id="name" class="block mt-1 w-full p-2" type="text" name="name"
                                                  :value="old('name', $user->name)" required autofocus/>

                                    <x-input-error :messages="$errors->get('Name')" class="mt-2"/>


                                </div>
                                <div class="w-full mt-2">
                                    <x-input-label for="social['twitter']" :value="__('twitter username')"/>

                                    <x-text-input id="twitter" class="block mt-1 w-full p-2" type="text"
                                                  name="social[twitter]"
                                                  :value="old('twitter', $user->social['twitter'] ?? '')"/>

                                    <x-input-error :messages="$errors->get('social[\'twitter\']')" class="mt-2"/>

                                </div>
                                <div class="w-full mt-2">
                                    <x-input-label for="social['instagram']" :value="__('instagram username')"/>

                                    <x-text-input id="instagram" class="block mt-1 w-full p-2" type="text"
                                                  name="social[instagram]"
                                                  :value="old('instagram', $user->social['instagram'] ?? '')"
                                    />

                                    <x-input-error :messages="$errors->get('social[\'instagram\']')" class="mt-2"/>

                                </div>
                                <div class="w-full mt-2">
                                    <x-input-label for="social['github']" :value="__('github username')"/>

                                    <x-text-input id="github" class="block mt-1 w-full p-2" type="text"
                                                  name="social[github]"
                                                  :value="old('github', $user->social['github'] ?? '')"/>

                                    <x-input-error :messages="$errors->get('social[\'github\']')" class="mt-2"/>

                                </div>
                                <div class="w-full mt-2">
                                    <x-input-label for="social['facebook']" :value="__('facebook username')"/>

                                    <x-text-input id="facebook" class="block mt-1 w-full p-2" type="text"
                                                  name="social[facebook]"
                                                  :value="old('facebook', $user->social['facebook'] ?? '')"
                                    />

                                    <x-input-error :messages="$errors->get('social[\'facebook\']')" class="mt-2"/>

                                </div>

                                <!-- Bio -->
                                <div class="w-full mt-2" x-data="{ content: '{{ old('bio', $user->bio) }}' }">
                                    <x-input-label for="bio" :value="__('Bio')"/>
                                    <x-textarea name="bio" id="bio" cols="30" rows="5" x-ref="bio"
                                                x-model="content"
                                                class="block mt-1 w-full p-2"></x-textarea>
                                    <span class="text-sm text-gray-500" x-ref="remaining"
                                          x-text="`${254 - content.length} of 254`"></span>
                                    <x-input-error :messages="$errors->get('bio')" class="mt-2"/>
                                </div>
                            </div>


                        </div>
                        <x-primary-button class="mt-3">
                            {{ __('Update Profile') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
