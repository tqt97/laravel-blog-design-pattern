<?php

return [
    'title' => 'Quản lý người dùng',
    'form' => [
        'name' => 'Họ và tên',
        'email' => 'Email',
        'role' => 'Vai trò',
        'status' => 'Trạng thái',
    ],
    'columns' => [
        'id' => 'ID',
        'name' => 'Tên người dùng',
        'email' => 'Email',
        'role' => 'Vai trò',
        'status' => 'Trạng thái',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'action' => 'Thao tác',
    ],
    'messages' => [
        'create_success' => 'Người dùng :name đã được tạo thành công.',
        'update_success' => 'Người dùng :name đã được cập nhật.',
        'delete_success' => 'Người dùng :name đã bị xóa.',
        'error_create' => 'Lỗi khi tạo người dùng.',
        'error_update' => 'Lỗi khi cập nhật người dùng.',
        'error_delete' => 'Lỗi khi xóa người dùng.',
    ],
];
