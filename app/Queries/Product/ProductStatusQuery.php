<?php

namespace App\Queries\Product;

class ProductStatusQuery
{
    public function __construct(
        public int $userId,
        public int $productId
    ) {}
}
