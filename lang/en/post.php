<?php

return [
    'title' => 'Posts',
    'form' => [
        'title' => 'Post Title',
        'content' => 'Content',
        'category' => 'Category',
        'status' => 'Status',
    ],
    'columns' => [
        'id' => 'ID',
        'title' => 'Post Title',
        'category' => 'Category',
        'status' => 'Status',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'action' => 'Actions',
    ],
    'messages' => [
        'create_success' => ':title has been created successfully.',
        'update_success' => ':title has been updated.',
        'delete_success' => ':title has been deleted.',
        'error_create' => 'Error occurred while creating post.',
        'error_update' => 'Error occurred while updating post.',
        'error_delete' => 'Error occurred while deleting post.',
    ],
];
