<?php

return [
    'title' => 'Quản lý quyền',
    'form' => [
        'name' => 'Tên quyền',
        'description' => 'Mô tả quyền',
    ],
    'columns' => [
        'id' => 'ID',
        'name' => 'Tên quyền',
        'description' => 'Mô tả',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'action' => 'Thao tác',
    ],
    'messages' => [
        'create_success' => 'Quyền :name đã được tạo thành công.',
        'update_success' => 'Quyền :name đã được cập nhật.',
        'delete_success' => 'Quyền :name đã bị xóa.',
        'error_create' => 'Lỗi khi tạo quyền.',
        'error_update' => 'Lỗi khi cập nhật quyền.',
        'error_delete' => 'Lỗi khi xóa quyền.',
    ],
];
