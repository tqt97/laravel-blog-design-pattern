@props([
    'title' => '',
    'action' => '',
    'hasFiles' => false,
    'method' => 'POST',
    'backRoute' => null,
])

<x-app-layout>
    <x-slot name="header">
        {{ $header }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">

                        <h2 class="text-xl font-medium mb-4">{{ $title }}</h2>
                        @if ($backRoute)
                        <a href="{{ $backRoute }}"
                            class="px-4 py-2 text-sm bg-gray-800 hover:bg-gray-900 text-white rounded-md dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                            ← {{ __('common.back') }}
                        </a>
                     @endif
                    </div>

                    <div class="bg-white border rounded-lg px-8 py-6 mx-auto my-8">
                        <form method="POST" action="{{ $action }}" {{ $hasFiles ? 'enctype=multipart/form-data' : '' }}>
                            @csrf

                            @if (strtoupper($method) !== 'POST')
                                @method($method)
                            @endif

                            {{ $form }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
