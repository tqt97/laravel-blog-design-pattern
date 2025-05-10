@props([
    'class' => 'bg-gray-100 text-gray-800',
    'label' => '--'
])

<td {{ $attributes->merge(['class' => 'text-sm font-medium text-gray-900 text-center']) }}>
    <span class="{{ $class }} text-xs font-medium px-2.5 py-1 rounded-full">
        {{ $label }}
    </span>
</td>
