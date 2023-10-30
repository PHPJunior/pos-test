<?php

namespace Domain\Category\Http\Data;

use Spatie\LaravelData\Data;

class CategoryData extends Data
{
    public function __construct(
        public string $name,
        public string $slug
    ){

    }
}
