<div class="overflow-x-auto">
    <table class="table-auto min-w-full rounded-lg table-striped border">
        <thead class="rounded-lg bg-gray-800 text-white">
            <tr>
                {{ $thead }}
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            {{ $slot }}
        </tbody>
    </table>
</div>
