<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Model;

    public function create(array $attributes): Model;

    public function update(Model $model, array $attributes): bool;

    public function delete(Model $model): bool;
}
