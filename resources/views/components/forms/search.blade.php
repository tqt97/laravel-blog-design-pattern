@props(['action'])

<form action="{{ $action }}" method="GET" class="flex">
    <input type="search" name="search" placeholder="Nhập từ khóa"
        class="px-4 py-[6px] bg-gray-50 border-gray-500 focus:bg-white focus:ring focus:ring-gray-800 focus:ring-opacity-0 rounded-l-md">
    <button type="submit" aria-label="{{ __('common.actions.search') }}"
        class="bg-gray-800 hover:bg-gray-900 text-white py-[6px] px-3 rounded-r-md">
        <x-icons.search class="text-white" />
    </button>
</form>
