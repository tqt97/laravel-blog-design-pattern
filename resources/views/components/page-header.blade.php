<div class="flex justify-between items-center mb-6">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $header }}
    </h2>
    <a href="{{ $link }}"
        class="flex items-center gap-2 px-4 py-2 text-sm bg-gray-800 hover:bg-gray-900 text-white rounded-md text-md">
        <x-icons.plus class="text-white" />
        {{ $linkLabel }}
    </a>
</div>
