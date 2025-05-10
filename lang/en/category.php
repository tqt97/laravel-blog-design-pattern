<?php

return [
    'title' => 'Categories',
    'name' => 'Category',
    'form' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'parent' => 'Parent Category',
        'image' => 'Image',
        'status' => 'Status',
    ],
    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'slug' => 'Slug',
        'parent' => 'Parent Category',
        'image' => 'Image',
        'status' => 'Status',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'action' => 'Actions',
    ],
    'messages' => [
        'create_success' => 'Successfully created',
        'update_success' => 'Successfully updated',
        'delete_success' => 'Successfully deleted',
        'has_posts' => 'This category has posts, cannot be deleted',
        'error_create' => 'Error creating category',
        'error_update' => 'Error updating category',
        'error_delete' => 'Error deleting category',
    ],
];
