<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Route::currentRouteName() == 'tasks.create' ? __('Add Task') : __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert class="mb-4" :errors="$errors" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ Route::currentRouteName() == 'tasks.create' ? route('tasks.store') : route('tasks.update', $task->id) }}" enctype="multipart/form-data">
                        @csrf

                        @if(Route::currentRouteName() == 'tasks.edit')
                            @method('PATCH')
                        @endif

                        <x-input id="title" class="block mt-1 w-full" type="hidden" name="id" :value="$task->id ?? 0" required autofocus />
                        <div>
                            <x-label for="title" :value="__('Title')" />

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$task->title ?? old('title')" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="description" :value="__('Description')" />

                            <textarea id="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="description" autofocus>{{$task->description ?? old('description')}}</textarea>
                        </div>
                        @if(Route::currentRouteName() == 'tasks.edit')
                            @if($task->subTask->count() <= 0)
                            <div class="mt-4">
                                <x-label for="library" :value="__('Status')" />

                                <select class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="status" id="status">
                                    @foreach ($status as $each_status)
                                        <option value="{{$each_status}}" {{($each_status ?? '') == $task->status ? 'selected' : ''}}>{{ucfirst($each_status)}}</option>
                                    @endforeach
                                </select>

                            </div>
                            @endif
                        @endif
                        <div class="mt-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">Upload file</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="image_help" id="image" name="image" type="file">
                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="image_help">
                                <a target="_blank" class="text-blue-500 hover:underline" href="{{($task->image->directory ?? '').($task->image->file_name ?? '')}}">{{$task->image->file_name ?? ''}}</a>
                                @if(isset($task->image->file_name))
                                <a target="_blank" class="text-blue-500 hover:underline font-sm" href="{{($task->image->directory ?? '').($task->image->file_name ?? '')}}" download><i class="ri-download-line"></i></a>
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
