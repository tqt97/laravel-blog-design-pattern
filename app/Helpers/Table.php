<?php

if (! function_exists('sortLink')) {
    function sortLink(string $label, string $field): string
    {
        $isCurrent = request('sort_by') === $field;
        $dir = request('sort_dir') === 'asc' ? 'desc' : 'asc';
        $icon = $isCurrent
            ? (request('sort_dir') === 'asc'
                ? view('components.icons.arrow-long-up')->render()
                : view('components.icons.arrow-long-down')->render())
            : view('components.icons.arrows-up-down')->render();
        $query = array_merge(request()->all(), ['sort_by' => $field, 'sort_dir' => $dir]);
        $url = request()->url().'?'.http_build_query($query);

        return <<<HTML
            <a href="{$url}" class="inline-flex items-center gap-1 hover:underline">
                <span>{$label}</span>
                {$icon}
            </a>
        HTML;
    }
}
