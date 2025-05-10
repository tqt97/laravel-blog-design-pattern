<x-layouts.list>
    <x-slot name="header">
        <x-breadcrumb :items="[['label' => 'category.title']]" />
    </x-slot>

    <x-slot name="headerActions">
        <x-page-header :header="__('category.title')" :link="route('admin.categories.create')"
            :linkLabel="__('common.actions.create')" />
    </x-slot>

    <x-slot name="bulkActions">
        <x-table.bulk-delete :route="route('admin.categories.bulk-delete')" />
    </x-slot>

    <x-slot name="search">
        <x-forms.search :action="route('admin.categories.index')" />
    </x-slot>

    <x-slot name="clearFilters">
        <x-clear-filters :route="route('admin.categories.index')" />
    </x-slot>

    <x-slot name="tableHead">
        <x-table.th.checkbox />
        <x-table.th label="{{ __('category.columns.image') }}" />
        <x-table.th.sort name="name" label="category.columns.name" />
        <x-table.th label="{{ __('category.columns.parent_category') }}" />
        <x-table.th.center label="{{ __('category.columns.order') }}" />
        <x-table.th class="text-center" label="{{ __('category.columns.is_active') }}" />
        <x-table.th.sort name="created_at" label="category.columns.created_at" />
        <x-table.th.sort name="updated_at" label="category.columns.updated_at" />
        <x-table.th class="text-center" label="{{ __('common.actions.actions') }}" />
    </x-slot>

    <x-slot name="tableBody">
        @forelse ($categories as $category)
            <tr class="bg-white hover:bg-gray-100">
                <x-table.td.checkbox :id="$category->id" />
                <x-table.td.image :src="$category->image_url" :alt="$category->name" />
                <x-table.td :value="$category->name" />
                <x-table.td :value="$category->parent?->name ?? '--'" />
                <x-table.td :value="$category->order" class="text-center"/>
                <x-table.td.badge :class="$category->statusBadgeClasses" :label="$category->statusLabel" />
                <x-table.td :value="$category->created_at" />
                <x-table.td :value="$category->updated_at" />
                <x-table.td.actions :actions="[
                'edit' => route('admin.categories.edit', $category),
                'delete' => route('admin.categories.destroy', $category),
            ]" />
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center py-3">
                    {{ __('common.no_data') }}
                </td>
            </tr>
        @endforelse
    </x-slot>

    <x-slot name="pagination">
        {{ $categories->links() }}
    </x-slot>

    @push('scripts')
        @vite('resources/js/admin/category-index.js')
    @endpush
</x-layouts.list>
