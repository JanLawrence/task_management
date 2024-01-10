@props(['errors', 'message' => ''])

@if ($errors->any())
    <div role="alert" {{ $attributes }}>
        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
            {{ __('Whoops! Something went wrong.') }}
        </div>
        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
            <ul class="list-none list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@else
    @if(session('message'))
        <div role="alert" {{ $attributes }}>
            <div class="bg-teal-500 text-white font-bold rounded-t px-4 py-2">
                {{ __('Success') }}
            </div>
            <div class="border border-t-0 border-teal-400 rounded-b bg-teal-100 px-4 py-3 text-teal-700">
                {{ $message }}
            </div>
        </div>
    @endif
@endif
