<?php

return [
    'title' => 'User Management',
    'form' => [
        'name' => 'Full Name',
        'email' => 'Email',
        'role' => 'Role',
        'status' => 'Status',
    ],
    'columns' => [
        'id' => 'ID',
        'name' => 'User Name',
        'email' => 'Email',
        'role' => 'Role',
        'status' => 'Status',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'action' => 'Actions',
    ],
    'messages' => [
        'create_success' => 'User :name has been created successfully.',
        'update_success' => 'User :name has been updated.',
        'delete_success' => 'User :name has been deleted.',
        'error_create' => 'Error occurred while creating user.',
        'error_update' => 'Error occurred while updating user.',
        'error_delete' => 'Error occurred while deleting user.',
    ],
];
