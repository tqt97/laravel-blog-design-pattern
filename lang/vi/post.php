<?php

return [
    'title' => 'Bài viết',
    'form' => [
        'title' => 'Tiêu đề bài viết',
        'content' => 'Nội dung',
        'category' => 'Danh mục',
        'status' => 'Trạng thái',
    ],
    'columns' => [
        'id' => 'ID',
        'title' => 'Tiêu đề bài viết',
        'category' => 'Danh mục',
        'status' => 'Trạng thái',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'action' => 'Thao tác',
    ],
    'messages' => [
        'create_success' => ':title đã được tạo thành công.',
        'update_success' => ':title đã được cập nhật.',
        'delete_success' => ':title đã được xóa.',
        'error_create' => 'Lỗi khi tạo bài viết.',
        'error_update' => 'Lỗi khi cập nhật bài viết.',
        'error_delete' => 'Lỗi khi xóa bài viết.',
    ],
];
