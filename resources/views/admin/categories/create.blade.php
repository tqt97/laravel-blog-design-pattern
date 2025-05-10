<x-layouts.form
    :title="__('common.actions.create')"
    :action="route('admin.categories.store')"
    :hasFiles="true" :backRoute="route('admin.categories.index')"
>

    <x-slot name="header">
        <x-breadcrumb :items="[
            ['label' => 'category.title', 'href' => route('admin.categories.index')],
            ['label' => 'common.actions.create'],
        ]" />
    </x-slot>

    <x-slot name="form">
        <div class="flex gap-4 items-center">
            <div class="mb-4 w-full">
                <x-forms.label name="name" :label="__('category.form.name')" required />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required />
            </div>
            <div class="mb-4 w-full">
                <x-forms.label name="slug" :label="__('category.form.slug')" />
                <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" value="{{ old('slug') }}" />
            </div>
        </div>

        <div class="flex gap-4 items-center">
            <div class="mb-4 w-full">
                <x-select name="parent_id" label="{{ __('category.form.parent') }}"
                    :options="$categories->pluck('name', 'id')"
                    placeholder="{{ __('category.form.no_select_parent') }}" />
                <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
            </div>
            <div class="mb-4 w-full">
                <x-forms.label name="order" :label="__('category.form.order')" />
                <x-text-input id="order" class="block mt-1 w-full" type="number" min="0" name="order" value="{{ old('order') ?? 0 }}" />
            </div>
        </div>

        <div class="flex gap-4 items-center">
            <div class="mb-4 w-full">
                <x-forms.label name="is_active" :label="__('category.form.status')" />
                <x-checkbox name="is_active" />
            </div>
            <div class="mb-4 w-full">
                <x-forms.label name="image" :label="__('category.form.image')" />
                <input type="file" id="image" class="block mt-2 w-full" name="image" />
            </div>
        </div>
        <div>
            <x-primary-button type="submit">{{ __('common.save') }}</x-primary-button>
        </div>
    </x-slot>

</x-layouts.form>
