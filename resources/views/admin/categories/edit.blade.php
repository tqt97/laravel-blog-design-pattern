<x-layouts.form :title="__('common.actions.create')" :action="route('admin.categories.update', $category)"
    :hasFiles="true" method="PUT" :backRoute="route('admin.categories.index')">

    <x-slot name="header">
        <x-breadcrumb :items="[
        ['label' => 'category.title', 'href' => route('admin.categories.index')],
        ['label' => 'common.actions.edit'],
    ]" />
    </x-slot>

    <x-slot name="form">
        <div class="flex gap-4 items-center">
            <div class="mb-4 w-full">
                <x-forms.label name="name" :label="__('category.form.name')" required />
                <x-text-input type="text" id="name" name="name" class="w-full mt-2" value="{{ $category->name }}" />
            </div>
            <div class="mb-4 w-full">
                <x-forms.label name="slug" :label="__('category.form.slug')" />
                <x-text-input type="text" id="slug" name="slug" class="w-full mt-2" value="{{ $category->slug }}" />
            </div>
        </div>
        <div class="flex gap-4 items-center">
            <div class="mb-4 w-full">
                <x-select name="parent_id" label="{{ __('category.form.parent') }}" :options="$categories->pluck('name', 'id')" :selected="$category->parent_id" placeholder="{{ __('category.form.no_select_parent') }}" />
            </div>
            <div class="mb-4 w-full">
                <x-forms.label name="order" :label="__('category.form.order')" />
                <x-text-input id="order" class="mt-2 w-full" type="number" min="0" name="order"
                    value="{{ $category->order }}" />
            </div>
        </div>
        <div class="flex gap-4 items-center">
            <div class="mb-4 w-full">
                <x-forms.label name="is_active" :label="__('category.form.status')" />
                <x-checkbox name="is_active" :checked="$category->is_active ?? false" />
            </div>
            <div class="mb-4 w-full">
                <x-forms.label name="image" :label="__('category.form.image')" />
                <input type="file" id="image" class="mt-2 w-full" type="text" name="image" />
            </div>
        </div>
        <div>
            <x-primary-button type="submit">{{ __('common.update') }}</x-primary-button>
        </div>
    </x-slot>

</x-layouts.form>
