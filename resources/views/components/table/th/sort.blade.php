@props([
    'name',
    'label',
])

<th class="py-3 text-left text-sm">
    {!! sortLink(__($label), $name) !!}
</th>
