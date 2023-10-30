<?php

namespace Domain\Product\Http\Data;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;
use Illuminate\Support\Str;

class ProductData extends Data
{
    public function __construct(
        public string $name,
        public string $slug,
        public float $price,
        public int $category_id,
    )
    {
    }
}
