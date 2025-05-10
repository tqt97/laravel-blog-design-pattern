<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="[
        ['label' => 'category.title', 'href' => route('admin.categories.index')],
        ['label' => 'common.actions.show'],
    ]" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="bg-white border rounded-lg px-8 py-6 mx-auto my-8">
                        <h1>{{ $category->name }}</h1>
                        <p>{{ $category->slug }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
