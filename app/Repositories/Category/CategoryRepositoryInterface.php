<?php

namespace App\Repositories\Category;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function getList(array $filters, int $perPage): LengthAwarePaginator;

    public function getByIds(array $ids): Collection;

    public function deleteByIds(array $ids): int;

    public function updateManyStatus(array $ids, string $status): int;

    public function getAllChildrenRecursively(array $parentIds): Collection;

    public function getImagesByCategoryIds(array $ids): Collection;
}
