<?php

namespace Domain\Shared;

use Domain\Shared\Interface\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseRepository implements RepositoryInterface
{
    public function __construct(private readonly Model $model)
    {

    }

    public function paginate(Request $request, array $relations = []): mixed
    {
        $query = $this->with($relations);

        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->get('name')}%");
        }

        if ($request->has('slug')) {
            $query->where('slug', 'like', "%{$request->get('slug')}%");
        }

        return $query->paginate($request->get('per_page', 5));
    }

    public function findBySlug(string $slug, array $relations = []): mixed
    {
        return $this->with($relations)->where('slug', $slug)->firstOrFail();
    }

    public function findById(int $id, array $relations = []): mixed
    {
        return $this->with($relations)->findOrFail($id);
    }

    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): mixed
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete(int $id): mixed
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function with(array $relations = []): mixed
    {
        return $this->model->with($relations);
    }

    public function withCount(array $relations = []): mixed
    {
        return $this->model->withCount($relations);
    }

    public function where(string $column, string $operator, string $value): mixed
    {
        return $this->model->where($column, $operator, $value);
    }
}
