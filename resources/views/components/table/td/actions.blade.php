<td class="flex items-center justify-center gap-2">
    @foreach($actions as $action => $route)
        @switch($action)
            @case('edit')
                <a href="{{ $route }}">
                    <x-icons.edit-pencil class="text-indigo-600 hover:text-indigo-900" />
                </a>
                @break

            @case('delete')
                <form action="{{ $route }}" method="POST" onsubmit="return confirm('{{ __('common.actions.confirm_delete') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="py-3" aria-label="{{ __('common.actions.delete') }}">
                        <x-icons.trash class="text-red-500 hover:text-red-700" />
                    </button>
                </form>
                @break

            {{-- @case('view')
                <a href="{{ $route }}">
                    <x-icons.view class="text-blue-600 hover:text-blue-900" />
                </a>
                @break --}}
        @endswitch
    @endforeach
</td>
