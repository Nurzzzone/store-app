<?php

namespace App\Queries\Product\Handlers;

use App\Models\Rental;
use App\Models\Transaction;
use App\Queries\Product\ProductStatusQuery;

class ProductStatusQueryHandler
{
    public function handle(ProductStatusQuery $query)
    {
        $purchase = Transaction::query()
            ->where('user_id', $query->userId)
            ->where('product_id', $query->productId)
            ->where('type', 'purchase')
            ->first();

        $rental = Rental::query()
            ->where('user_id', $query->userId)
            ->where('product_id', $query->productId)
            ->where('status', 'active')
            ->first();

        return [
            'status' => $purchase ? 'purchased' : ($rental ? 'rented' : 'available'),
            'unique_code' => $rental->unique_code ?? null,
            'rental_end_time' => $rental->end_time ?? null,
        ];
    }
}
