@props(['type' => 'success'])

@php
    $colors = [
        'success' => 'green',
        'error' => 'red',
        'warning' => 'yellow',
        'info' => 'blue',
    ];

    $color = $colors[$type] ?? 'gray';
@endphp

@if (session($type))
    <div class="relative items-center w-full px-8 py-6 mx-auto md:px-12 lg:px-8 max-w-7xl">
        <div @class([
            "p-4 border border-l-4 rounded-l-md rounded-r-md shadow-md",
            "bg-green-50 border-green-500" => $color === 'green',
            "bg-red-50 border-red-500" => $color === 'red',
            "bg-yellow-50 border-yellow-500" => $color === 'yellow',
            "bg-blue-50 border-blue-500" => $color === 'blue',
        ])>
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-{{ $color }}-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <div class="text-sm text-{{ $color }}-600">
                        <p>{{ session($type) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
