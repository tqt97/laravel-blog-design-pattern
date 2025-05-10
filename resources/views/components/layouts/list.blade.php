<x-app-layout>
    <div>
        {{-- Header breadcrumb --}}
        <x-slot name="header">
            {{ $header }}
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg shadow-md">
                    <div class="p-6 text-gray-900 dark:text-gray-100 shadow-md" x-data="{ showFilter: false }">

                        {{-- Header actions --}}
                        {{ $headerActions ?? '' }}

                        {{-- Bulk + Search + Clear Filters --}}
                        <div class="flex items-center justify-between gap-2 mb-4 min-h-10">
                            <div class="flex items-center gap-2">
                                {{ $bulkActions ?? '' }}
                            </div>
                            <div class="flex flex-end items-center gap-1">
                                {{ $search ?? '' }}
                                {{ $clearFilters ?? '' }}
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="overflow-x-auto pb-4" x-transition>
                            <div class="min-w-full inline-block align-middle">
                                <div class="overflow-hidden rounded-lg">
                                    <x-table.datatable>
                                        <x-slot name="thead">
                                            {{ $tableHead }}
                                        </x-slot>
                                        {{ $tableBody }}
                                    </x-table.datatable>

                                    {{-- Pagination --}}
                                    <div class="pt-6 border-t border-gray-200 bg-white">
                                        {{ $pagination ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
