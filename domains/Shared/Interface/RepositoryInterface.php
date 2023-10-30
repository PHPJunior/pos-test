<?php

namespace Domain\Shared\Interface;

use Illuminate\Http\Request;

interface RepositoryInterface
{
    public function paginate(Request $request, array $relations = []): mixed;

    public function findBySlug(string $slug, array $relations = []): mixed;

    public function findById(int $id, array $relations = []): mixed;

    public function create(array $data): mixed;

    public function update(int $id, array $data): mixed;

    public function delete(int $id): mixed;
}
