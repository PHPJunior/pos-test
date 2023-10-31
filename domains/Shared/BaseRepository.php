<?php

namespace Domain\Shared;

use Domain\Shared\Interface\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseRepository implements RepositoryInterface
{
    /**
     * @param Model $model
     */
    public function __construct(private readonly Model $model)
    {
    }

    /**
     * @param Request $request
     * @param array $relations
     * @return mixed
     */
    public function paginate(Request $request, array $relations = []): mixed
    {
        $query = $this->with($relations);

        if ($request->has('name')) {
            $query->orWhere('name', 'like', "%{$request->get('name')}%");
        }

        if ($request->has('slug')) {
            $query->orWhere('slug', 'like', "%{$request->get('slug')}%");
        }

        if ($request->get('order_by', [])) {
            foreach ($request->get('order_by') as $orderBy) {
                $query->orderBy($orderBy['column'], $orderBy['direction']);
            }
        }

        return $query->paginate($request->get('per_page', 5));
    }

    /**
     * @param string $slug
     * @param array $relations
     * @return mixed
     */
    public function findBySlug(string $slug, array $relations = []): mixed
    {
        return $this->with($relations)->where('slug', $slug)->firstOrFail();
    }

    /**
     * @param int $id
     * @param array $relations
     * @return mixed
     */
    public function findById(int $id, array $relations = []): mixed
    {
        return $this->with($relations)->findOrFail($id);
    }

    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return $model;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): mixed
    {
        return $this->model->findOrFail($id)->delete();
    }

    /**
     * @param array $relations
     * @return mixed
     */
    public function with(array $relations = []): mixed
    {
        return $this->model->with($relations);
    }

    /**
     * @param array $relations
     * @return mixed
     */
    public function withCount(array $relations = []): mixed
    {
        return $this->model->withCount($relations);
    }

    /**
     * @param string $column
     * @param string $operator
     * @param string $value
     * @return mixed
     */
    public function where(string $column, string $operator, string $value): mixed
    {
        return $this->model->where($column, $operator, $value);
    }

    public function all(): mixed
    {
        return $this->model->all();
    }
}
