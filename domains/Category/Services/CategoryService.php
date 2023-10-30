<?php

namespace Domain\Category\Services;

use Domain\Category\Http\Data\CategoryData;
use Domain\Category\Http\Data\CategoryUpdateData;
use Domain\Category\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryService
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    /**
     * @param Request $request
     * @param array $relations
     * @return mixed
     */
    public function paginate(Request $request, array $relations): mixed
    {
        return $this->categoryRepository->paginate($request, $relations);
    }

    /**
     * @param CategoryData $data
     * @return mixed
     */
    public function create(CategoryData $data): mixed
    {
        return $this->categoryRepository->create($data->toArray());
    }

    /**
     * @param CategoryData $data
     * @param int $id
     * @return mixed
     */
    public function update(CategoryData $data, int $id): mixed
    {
        return $this->categoryRepository->update($id, $data->toArray());
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): mixed
    {
        return $this->categoryRepository->delete($id);
    }

    /**
     * @param int $id
     * @param array $relations
     * @return mixed
     */
    public function findById(int $id, array $relations): mixed
    {
        return $this->categoryRepository->findById($id, $relations);
    }

    /**
     * @param string $slug
     * @param array $relations
     * @return mixed
     */
    public function findBySlug(string $slug, array $relations): mixed
    {
        return $this->categoryRepository->findBySlug($slug, $relations);
    }
}
