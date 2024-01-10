<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert class="mb-5" :message="session('message')" />
            <div class="mb-5 text-right">
                <x-button type="link" link="{{route('users.create')}}" class="mb-5">
                    {{ __('Add') }}
                </x-button>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                    <div class="w-full align-middle">
                        <table class="w-full divide-y divide-gray-200 border">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left border">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left border">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left border w-10">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></span>
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @if($users->count() > 0)
                                    @foreach($users as $each_user)
                                        <tr class="bg-white">
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border">
                                                {{$each_user->name}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border">
                                                {{$each_user->email}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border">
                                                <div class="flex">
                                                    <x-button type="link" link="{{route('users.edit', $each_user->id)}}">
                                                        {{ __('Edit') }}
                                                    </x-button>
                                                    <form method="POST" action="{{route('users.destroy', $each_user->id)}}" onsubmit="return confirm('Do you want to delete this book?')">
                                                        @method('DELETE')
                                                        @csrf
                                                        <x-button type="submit" color="danger" class="ml-1">
                                                            {{ __('Delete') }}
                                                        </x-button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border text-center" colspan="3">
                                            No data available
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
