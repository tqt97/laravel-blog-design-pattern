<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function all(): Collection
    {
        return $this->newQuery()->get();
    }

    public function find(int|string $id): ?Model
    {
        return $this->newQuery()->find($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(Model $model, array $attributes): bool
    {
        $model->fill($attributes);

        if (! $model->isDirty()) {
            return true;
        }

        return $model->save();
    }

    public function delete(Model $model): bool
    {
        // dd($model);
        // return $model->delete();
        return $model->delete();
    }

    protected function newQuery(): Builder
    {
        return $this->model->newQuery();
    }
}
