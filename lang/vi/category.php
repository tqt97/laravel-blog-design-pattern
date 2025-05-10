<?php

return [
    'title' => 'Danh mục bài viết',
    'name' => 'Danh mục',
    'form' => [
        'name' => 'Tên danh mục',
        'slug' => 'Slug',
        'parent' => 'Danh mục cha',
        'image' => 'Hình ảnh',
        'status' => 'Trạng thái',
        'order' => 'Sắp xếp',
        'no_select_parent' => 'Chọn danh mục',
    ],
    'columns' => [
        'id' => 'ID',
        'name' => 'Tên danh mục',
        'slug' => 'Slug',
        'parent' => 'Danh mục cha',
        'image' => 'Hình ảnh',
        'status' => 'Trạng thái',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'action' => 'Thao tác',
        'is_active' => 'Trạng thái',
        'order' => 'Sắp xếp',
        'parent_category' => 'Danh mục cha',
    ],
    'messages' => [
        'create_success' => 'Thêm thành công',
        'update_success' => 'Cập nhật thành công',
        'delete_success' => 'Xóa thành công',
        'has_posts' => 'Danh mục đang có bài viết, không thể xóa',
        'error_create' => 'Lỗi khi tạo danh mục',
        'error_update' => 'Lỗi khi cập nhật danh mục',
        'error_delete' => 'Lỗi khi xóa danh mục',
    ],
];
