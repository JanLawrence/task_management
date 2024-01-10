<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Change Password') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-alert class="mb-4" :errors="$errors" :message="session('message')"/>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('change-password.update', $user->id) }}">
                        @csrf

                        <!-- Password -->
                        <div>
                            <x-label for="old_password" :value="__('Old Password')" />

                            <x-input id="old_password" class="block mt-1 w-full" type="password" name="old_password" required />
                        </div>
                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('New Password')" />

                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password"
                                                name="password_confirmation" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button type="submit">
                                {{ __('Reset Password') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
