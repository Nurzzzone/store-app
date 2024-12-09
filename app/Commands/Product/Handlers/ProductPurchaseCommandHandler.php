<?php

namespace App\Commands\Product\Handlers;

use App\Commands\Product\ProductPurchaseCommand;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class ProductPurchaseCommandHandler
{
    public function handle(ProductPurchaseCommand $command): void
    {
        $user = User::query()->findOrFail($command->userId);
        $product = Product::query()->findOrFail($command->productId);

        if ($user->balance < $product->price) {
            throw new \Exception('Insufficient balance.');
        }

        DB::transaction(function () use ($user, $product, $command) {
            $user->balance -= $product->price;
            $user->save();

            Transaction::query()->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'type' => 'purchase',
                'amount' => $product->price,
            ]);
        });
    }
}
