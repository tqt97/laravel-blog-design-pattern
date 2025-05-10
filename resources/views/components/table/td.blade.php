{{-- <td class="whitespace-nowrap text-sm font-medium text-gray-900">
    {{ $slot }}
</td> --}}


<td {{ $attributes->merge(['class' => 'text-sm text-gray-900']) }}>
    {{ $value ?? '--' }}
</td>
