@props(['route'])

<form id="bulk-delete-form" method="POST" action="{{ $route }}">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
    <button type="submit" aria-label="{{ __('common.actions.bulk_delete') }}" id="bulk-delete-button"
        style="display: none;" class="px-4 py-2 text-white rounded-md transition
                                bg-red-500 hover:bg-red-600
                                disabled:opacity-0 disabled:cursor-not-allowed"
        onclick="return confirm('{{ __('common.actions.confirm_bulk_delete') }}')">
        {{ __('common.actions.bulk_delete') }}
    </button>
</form>
<div id="selected-count" class="text-gray-700" style="display: none;">
    Đã chọn <strong id="selected-count-number"></strong> mục
</div>
