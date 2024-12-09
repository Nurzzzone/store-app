<?php

namespace App\Commands\Product;

final class ProductRentCommand
{
    public function __construct(
        public int $productId,
        public int $userId,
        public int $duration,
    ) {
    }
}
