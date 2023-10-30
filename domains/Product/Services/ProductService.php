<?php

namespace Domain\Product\Services;

use Domain\Product\Http\Data\ProductData;
use Domain\Product\Repositories\ProductRepository;

class ProductService
{
    public function __construct(private readonly ProductRepository $repository)
    {
    }

    /**
     * @param $request
     * @param array $relations
     * @return mixed
     */
    public function paginate($request, array $relations): mixed
    {
        return $this->repository->paginate($request, $relations);
    }

    /**
     * @param int $id
     * @param array $relations
     * @return mixed
     */
    public function findById(int $id, array $relations): mixed
    {
        return $this->repository->findById($id, $relations);
    }

    /**
     * @param ProductData $data
     * @return mixed
     */
    public function create(ProductData $data): mixed
    {
        return $this->repository->create($data->toArray());
    }

    /**
     * @param ProductData $data
     * @param int $id
     * @return mixed
     */
    public function update(ProductData $data, int $id): mixed
    {
        return $this->repository->update($id, $data->toArray());
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): mixed
    {
        return $this->repository->delete($id);
    }
}
