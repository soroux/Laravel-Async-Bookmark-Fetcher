<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function list(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->query()->select($columns)->with($relations)->get();
    }

    public function listPaginated(array $columns = ['*'], array $relations = [], int $perPage = 50): LengthAwarePaginator
    {
        return $this->model->query()->select($columns)->with($relations)->paginate($perPage);
    }

    /**
     * @param string $modelId
     * @param array $columns
     * @param array $relations
     * @return Model|null
     */
    public function findById(string $modelId, array $columns = ['*'], array $relations = []): Model|null
    {
        return $this->model->query()->select($columns)->with($relations)->find($modelId);
    }

    /**
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): Model
    {
        return $this->model->query()->create($payload);
    }

    public function update(string $modelId, array $payload): bool
    {
        $model = $this->model->query()->findOrFail($modelId);

        return $model->update($payload);
    }

    public function deleteById(string $modelId): ?bool
    {
        return $this->model->query()->findOrFail($modelId)->delete();
    }
}
