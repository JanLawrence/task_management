<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Route::currentRouteName() == 'users.create' ? __('Add User') : __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert class="mb-4" :errors="$errors" :message="session('message')" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ Route::currentRouteName() == 'users.create' ? route('users.store') : route('users.update', $user->id) }}">
                        @csrf

                        @if(Route::currentRouteName() == 'users.edit')
                            @method('PATCH')
                        @endif

                        <x-input id="name" class="block mt-1 w-full" type="hidden" name="id" :value="$user->id ?? 0" required autofocus />
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name ?? old('name')" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email ?? old('email')" disabled="{{Route::currentRouteName() == 'users.edit' ? true : false}}" autofocus />
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <x-button color="light" type="link" link="{{route('users.index')}}">
                                {{ __('Cancel') }}
                            </x-button>
                            <x-button class="ml-4">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
