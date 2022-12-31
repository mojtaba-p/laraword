<x-app-layout class="bg-gray-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="dashboard-container">
        @include('dashboard._partials.messages')
        @include('management.users._actions')
    @foreach($users as $user)
            <div class="mb-2">
                <div class="dashboard-white-item flex flex-row items-center">
                    <div class="w-1/12 md:w-10 mx-3">
                        <x-user-photo :user="$user"/>
                    </div>
                    <div class=" p-2 w-5/12 md:p-6 md:w-7/12">
                        <a href="{{ '/@'.$user->username }}">
                            {{ $user->name }}
                            <span class="text-sm text-gray-500">
                                {{ '@'.$user->username }}
                            </span>
                        </a>
                        <span class="text-xs text-blue-400 pl-2">
                                @if($user->email_verified_at)
                                {{ __('Verified At '). $user->email_verified_at }}
                            @endif
                            </span>
                    </div>
                    <div class="mx-3 flex flex-row w-3/12 md:w-1/12 text-center">
                        <span class="border-indigo-200 px-2 py-1 rounded-xl space-x-2 border-2 mx-auto">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div class="p-2 w-16 flex flex-row items-start ml-auto">
                        <x-svg.document-text class="w-4"/>
                        <span class="text-xs">{{ $user->articles_count }}</span>
                    </div>
                    <div class="p-2 w-16 flex flex-row items-start">
                        <x-svg.thumb-up class="w-4"/>
                        <span class="text-xs">{{ $user->likes_count }}</span>
                    </div>
                    <div class="p-2 w-16 flex flex-row items-start">
                        <x-svg.chat class="w-4"/>
                        <span class="text-xs">{{ $user->comments_count }}</span>
                    </div>
                    <div class="ml-auto p-2 w-10">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <x-svg.horizontal-dots class="w-4"/>
                            </x-slot>
                            <x-slot name="content" class="p-2">
                                <div class="p-3">{{ __('Change Role To') }}</div>
                                <form action="{{ route('management.users.update.role') }}" x-ref="form" method="post"
                                      x-data="{role:''}">
                                    @csrf
                                    <input type="hidden" name="role" x-ref="role">
                                    <input type="hidden" name="username" value="{{ $user->username }}">

                                    <button class="w-full text-left drop-down-item"
                                            @click.prevent="$refs.role.value='manager'; $refs.form.submit()"
                                    >{{ __('Manager') }}
                                    </button>
                                    <button class="w-full text-left drop-down-item"
                                            @click.prevent="$refs.role.value='editor'; $refs.form.submit()"
                                    >{{ __('Editor') }}
                                    </button>
                                    <button class="w-full text-left drop-down-item"
                                            @click.prevent="$refs.role.value='user'; $refs.form.submit()"
                                    >{{ __('User') }}
                                    </button>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $users->appends($_GET)->links() }}

    </div>
</x-app-layout>
