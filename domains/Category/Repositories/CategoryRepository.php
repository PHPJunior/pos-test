<?php

namespace Domain\Category\Repositories;

use Domain\Category\Models\Category;
use Domain\Shared\BaseRepository;

class CategoryRepository extends BaseRepository
{

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
