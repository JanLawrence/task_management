<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert class="mb-5" :message="session('message')" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-3">
                        {{ __('Tasks') }}
                    </h2>
                    <div class="flex justify-between items-center mb-5">
                        <form>
                            <div class="flex justify-between items-center">
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input name="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
                                </div>
                                <div class="flex justify-between items-center">
                                    <select id="field" name="field" class="bg-gray-50 ml-3 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="created_at" {{request()->get('field') == 'created_at' ? 'selected' : ''}}>Date Created</option>
                                        <option value="status" {{request()->get('field') == 'status' ? 'selected' : ''}}>Status</option>
                                    </select>
                                </div>
                                <div class="flex justify-between items-center">
                                    <select id="sortOrder" name="sortOrder" class="bg-gray-50 ml-3 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @if(request()->get('field') == 'status')
                                            <option value="to-do" {{request()->get('sortOrder') == 'to-do' ? 'selected' : ''}}>To-do</option>
                                            <option value="in-progress" {{request()->get('sortOrder') == 'in-progress' ? 'selected' : ''}}>In-progress</option>
                                            <option value="completed" {{request()->get('sortOrder') == 'completed' ? 'selected' : ''}}>Completed</option>
                                        @else
                                            <option value="desc" {{request()->get('sortOrder') == 'desc' ? 'selected' : ''}}>Desc</option>
                                            <option value="asc" {{request()->get('sortOrder') == 'asc' ? 'selected' : ''}}>Asc</option>
                                        @endif
                                    </select>
                                </div>
                                <button type="submit" class="ml-6  text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-4 py-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Filter</button>
                                <a href="{{route('dashboard')}}" role="button" class="ml-2 text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm px-4 py-2 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">Clear</a>
                            </div>
                        </form>
                        <div>
                            <a role="button" href="{{route('dashboard.trashed-tasks')}}" class="items-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-3 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">{{ __('Trashed tasks') }}</a>
                            <a role="button" href="{{route('tasks.create')}}" class="items-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-3 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"><i class="ri-add-circle-line"></i> {{ __('Add new task') }}</a>
                        </div>
                    </div>

                    @if($tasks->count() > 0)
                        <div id="accordion-nested-parent" data-accordion="collapse">
                            @foreach($tasks as $key => $task)
                                <h2 id="accordion-collapse-heading-{{$key}}">
                                    <button type="button"
                                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 rounded focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                        data-accordion-target="#accordion-collapse-body-{{$key}}" aria-expanded="true"
                                        aria-controls="accordion-collapse-body-{{$key}}">
                                        <span>{{ucfirst($task->title)}}</span>
                                        <div class="flex items-center">
                                            <div class="flex items-center mr-5"><div style="width: 0.4rem; height: 0.4rem" class="bg-{{$task->status == 'in-progress' ? 'yellow' : ($task->status == 'completed' ? 'green' : 'gray')}}-500 rounded-full mr-2"></div> {{ucfirst($task->status)}}</div>
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{\Carbon\Carbon::parse($task->created_at)->format('F j, Y')}}</span>
                                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M9 5 5 1 1 5" />
                                            </svg>
                                        </div>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-{{$key}}" class="hidden"
                                    aria-labelledby="accordion-collapse-heading-{{$key}}">
                                    <div class="p-5 border border-gray-200">
                                        <div class="grid grid-cols-2  mb-5">
                                            <div>
                                                <label class="text-gray-800 font-bold text-xs mb-3">Details</label>
                                                <p class="mb-4 text-gray-500 dark:text-gray-400">{{ucfirst($task->description)}}</p>
                                                <div class="flex">
                                                    @if($task->subTask->count() <= 0)
                                                    <button id="dropdownDefaultButton{{$key}}" data-dropdown-toggle="dropdown{{$key}}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center" type="button">
                                                        <div style="width: 0.4rem; height: 0.4rem" class="bg-{{$task->status == 'in-progress' ? 'yellow' : ($task->status == 'completed' ? 'green' : 'gray')}}-500 rounded-full mr-2"></div> {{ucfirst($task->status)}} <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                                        </svg>
                                                    </button>

                                                    <!-- Dropdown menu -->
                                                    <div id="dropdown{{$key}}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton{{$key}}">
                                                            @foreach ($status as $each_status)
                                                                @if($task->status != $each_status)
                                                                <li>
                                                                    <form method="POST" action="{{route('change-status', ['type' => 'task' , 'id' => $task->id, 'status' => $each_status])}}"
                                                                        onsubmit="return confirm('Are you sure you want to change this status?')">
                                                                        @csrf
                                                                        <button type="submit" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-gray w-full text-left"><div style="width: 0.4rem; height: 0.4rem" class="bg-{{$each_status == 'in-progress' ? 'yellow' : ($each_status == 'completed' ? 'green' : 'gray')}}-500 rounded-full mr-2 inline-flex items-center"></div> <span>{{ucfirst($each_status)}}</span></a>
                                                                    </form>
                                                                </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif

                                                    <a href="{{route('tasks.edit', $task)}}" role="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Edit</a>
                                                    <form method="POST" action="{{route('tasks.destroy', $task->id)}}"
                                                        onsubmit="return confirm('Are you sure you want to delete this task?')">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Move to trash</a>
                                                    </form>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="text-gray-800 font-bold text-xs mb-3">Attachments</label><br>
                                                @if($task->image)
                                                <a target="_blank" class="text-blue-500 hover:underline font-sm" href="{{($task->image->directory ?? '').($task->image->file_name ?? '')}}">{{$task->image->file_name ?? ''}}</a>
                                                <a target="_blank" class="text-blue-500 hover:underline font-sm" href="{{($task->image->directory ?? '').($task->image->file_name ?? '')}}" download><i class="ri-download-line"></i></a>
                                                @else
                                                <p class="mb-4 text-gray-500 dark:text-gray-400">No data available</p>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Nested accordion -->
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-gray-800 font-semibold text-sm mb-4">Sub-tasks</h4>
                                            <a role="button" href="{{route('sub-tasks.create', $task->id)}}" class="items-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-xs px-5 py-3 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"><i class="ri-add-circle-line"></i> {{ __('Add new sub-task') }}</a>
                                        </div>
                                        @if($task->subTask->count() > 0)
                                        <div id="accordion-nested-collapse-{{$key}}" data-accordion="collapse">
                                            @foreach($task->subTask as $key => $sub_task)
                                            <h2 id="accordion-nested-collapse-{{$key}}-heading-{{$sub_task->id}}-{{$key}}">
                                                <button type="button"
                                                    class="flex items-center justify-between w-full p-5 rounded font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                                    data-accordion-target="#accordion-nested-collapse-{{$key}}-body-{{$sub_task->id}}-{{$key}}"
                                                    aria-expanded="false" aria-controls="accordion-nested-collapse-{{$key}}-body-{{$sub_task->id}}-{{$key}}">
                                                    <span>{{$sub_task->title}}</span>
                                                    <div class="flex items-center">
                                                        <div class="flex items-center mr-5"><div style="width: 0.4rem; height: 0.4rem" class="bg-{{$sub_task->status == 'in-progress' ? 'yellow' : ($sub_task->status == 'completed' ? 'green' : 'gray')}}-500 rounded-full mr-2"></div> {{ucfirst($sub_task->status)}}</div>
                                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 5 5 1 1 5" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="accordion-nested-collapse-{{$key}}-body-{{$sub_task->id}}-{{$key}}" class="hidden"
                                                aria-labelledby="accordion-nested-collapse-{{$key}}-heading-{{$sub_task->id}}-{{$key}}">
                                                <div class="p-5 border border-gray-200 dark:border-gray-700">
                                                    <div class="grid grid-cols-2">
                                                        <div>
                                                            <label class="text-gray-800 font-bold text-xs mb-3">Details</label>
                                                            <p class="mb-4 text-gray-500 dark:text-gray-400">{{ucfirst($sub_task->description)}}</p>
                                                            <div class="flex">
                                                                <button id="dropdownDefaultButton{{$sub_task->id}}-{{$key}}" data-dropdown-toggle="dropdown{{$sub_task->id}}-{{$key}}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center" type="button">
                                                                    <div style="width: 0.4rem; height: 0.4rem" class="bg-{{$sub_task->status == 'in-progress' ? 'yellow' : ($sub_task->status == 'completed' ? 'green' : 'gray')}}-500 rounded-full mr-2"></div> {{ucfirst($sub_task->status)}} <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                                                    </svg>
                                                                </button>

                                                                <!-- Dropdown menu -->
                                                                <div id="dropdown{{$sub_task->id}}-{{$key}}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton{{$sub_task->id}}-{{$key}}">
                                                                        @foreach ($status as $each_status)
                                                                            @if($sub_task->status != $each_status)
                                                                            <li>
                                                                                <form method="POST" action="{{route('change-status', ['type' => 'sub' , 'id' => $sub_task->id, 'status' => $each_status])}}"
                                                                                    onsubmit="return confirm('Are you sure you want to change this status?')">
                                                                                    @csrf
                                                                                    <button type="submit" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-gray w-full text-left"><div style="width: 0.4rem; height: 0.4rem" class="bg-{{$each_status == 'in-progress' ? 'yellow' : ($each_status == 'completed' ? 'green' : 'gray')}}-500 rounded-full mr-2 inline-flex items-center"></div> <span>{{ucfirst($each_status)}}</span></a>
                                                                                </form>
                                                                            </li>
                                                                            @endif
                                                                        @endforeach
                                                                    </ul>
                                                                </div>

                                                                <a href="{{route('sub-tasks.edit', $sub_task)}}" role="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Edit</a>
                                                                <form method="POST" action="{{route('sub-tasks.destroy', $sub_task->id)}}"
                                                                    onsubmit="return confirm('Are you sure you want to delete this task?')">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</a>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label class="text-gray-800 font-bold text-xs mb-3">Attachments</label><br>
                                                            @if($sub_task->image)
                                                            <a target="_blank" class="text-blue-500 hover:underline font-sm" href="{{($sub_task->image->directory ?? '').($sub_task->image->file_name ?? '')}}">{{$sub_task->image->file_name ?? ''}}</a>
                                                            <a target="_blank" class="text-blue-500 hover:underline font-sm" href="{{($sub_task->image->directory ?? '').($sub_task->image->file_name ?? '')}}" download><i class="ri-download-line"></i></a>
                                                            @else
                                                            <p class="mb-4 text-gray-500 dark:text-gray-400">No data available</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <!-- End: Nested accordion -->
                                        @else
                                        <p class="mb-4 text-gray-500 dark:text-gray-400">No data available</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h4>No data available</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('#field').change(function(){
                let value = $(this).val();
                if(value == 'status'){
                    $('#sortOrder').html(`
                        <option value="to-do" {{request()->get('sortOrder') == 'to-do' ? 'selected' : ''}}>To-do</option>
                        <option value="in-progress" {{request()->get('sortOrder') == 'in-progress' ? 'selected' : ''}}>In-progress</option>
                        <option value="completed" {{request()->get('sortOrder') == 'completed' ? 'selected' : ''}}>Completed</option>
                    `);
                } else {
                    $('#sortOrder').html(`
                        <option value="desc" {{request()->get('sortOrder') == 'desc' ? 'selected' : ''}}>Desc</option>
                        <option value="asc" {{request()->get('sortOrder') == 'asc' ? 'selected' : ''}}>Asc</option>
                    `);
                }
            })
        })
    </script>
</x-app-layout>
