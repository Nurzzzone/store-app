<?php

namespace App\Commands\Product;

final class ProductPurchaseCommand
{
    public function __construct(
        public int $productId,
        public int $userId,
    ) {
    }
}
