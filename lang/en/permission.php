<?php

return [
    'title' => 'Role Management',
    'form' => [
        'name' => 'Role Name',
        'description' => 'Role Description',
    ],
    'columns' => [
        'id' => 'ID',
        'name' => 'Role Name',
        'description' => 'Description',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'action' => 'Actions',
    ],
    'messages' => [
        'create_success' => 'Role :name has been created successfully.',
        'update_success' => 'Role :name has been updated.',
        'delete_success' => 'Role :name has been deleted.',
        'error_create' => 'Error occurred while creating role.',
        'error_update' => 'Error occurred while updating role.',
        'error_delete' => 'Error occurred while deleting role.',
    ],
];
