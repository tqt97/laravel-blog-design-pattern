<?php

use App\Models\Category;

return [
    'defaults' => [
        'from' => 'title',
        'to' => 'slug',
        'separator' => '-',
        'unique' => true,
        'overwrite_on_update' => true,
    ],
    'bindings' => [
        'category' => [
            'model' => Category::class,
            'route' => 'admin.categories.show',
        ],
    ],
];
