<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Route::currentRouteName() == 'sub-tasks.create' ? __('Add Sub-Task ('.ucfirst($task->title).')') : __('Edit Sub-Task ('.ucfirst($task->title).')') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert class="mb-4" :errors="$errors" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ Route::currentRouteName() == 'sub-tasks.create' ? route('sub-tasks.store', $task->id) : route('sub-tasks.update', $subTask->id) }}" enctype="multipart/form-data">
                        @csrf

                        @if(Route::currentRouteName() == 'sub-tasks.edit')
                            @method('PATCH')
                        @endif

                        <x-input id="title" class="block mt-1 w-full" type="hidden" name="id" :value="$subTask->id ?? 0" required autofocus />
                        <div>
                            <x-label for="title" :value="__('Title')" />

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$subTask->title ?? old('title')" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="description" :value="__('Description')" />

                            <textarea id="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="description" autofocus>{{$subTask->description ?? old('description')}}</textarea>
                        </div>
                        @if(Route::currentRouteName() == 'sub-tasks.edit')
                        <div class="mt-4">
                            <x-label for="library" :value="__('Status')" />

                            <select class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="status" id="status">
                                @foreach ($status as $each_status)
                                    <option value="{{$each_status}}" {{($each_status ?? '') == $subTask->status ? 'selected' : ''}}>{{ucfirst($each_status)}}</option>
                                @endforeach
                            </select>

                        </div>
                        @endif
                        <div class="mt-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">Upload file</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="image_help" id="image" name="image" type="file">
                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="image_help">
                                <a target="_blank" class="text-blue-500 hover:underline" href="{{($subTask->image->directory ?? '').($subTask->image->file_name ?? '')}}">{{$subTask->image->file_name ?? ''}}</a>
                                @if(isset($subTask->image->file_name))
                                <a target="_blank" class="text-blue-500 hover:underline font-sm" href="{{($subTask->image->directory ?? '').($subTask->image->file_name ?? '')}}" download><i class="ri-download-line"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <x-button color="light" type="link" link="{{route('dashboard')}}">
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
