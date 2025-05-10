<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getList(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->filter($filters)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * Xóa nhiều category theo mảng ID.
     */
    public function deleteByIds(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    /**
     * Cập nhật status cho nhiều category.
     */
    public function updateManyStatus(array $ids, string $status): int
    {
        return $this->model->whereIn('id', $ids)->update(['status' => $status]);
    }

    /**
     * Lấy tất cả các category con đệ quy từ danh sách ID ban đầu.
     */
    public function getAllChildrenRecursively(array $parentIds): Collection
    {
        $result = collect();
        $stack = $parentIds;

        while (! empty($stack)) {
            $children = $this->model->whereIn('parent_id', $stack)->get();
            $result = $result->merge($children);
            $stack = $children->pluck('id')->toArray();
        }

        return $result;
    }

    /**
     * Lấy danh sách ảnh từ các category theo IDs (cho xóa ảnh).
     */
    public function getImagesByCategoryIds(array $ids): Collection
    {
        return $this->model
            ->with('image')
            ->whereIn('id', $ids)
            ->get()
            ->pluck('image')
            ->filter(); // Loại bỏ null nếu category không có ảnh
    }
}
