<?php

namespace Domain\Product\Repositories;

use Domain\Product\Models\Product;
use Domain\Shared\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
