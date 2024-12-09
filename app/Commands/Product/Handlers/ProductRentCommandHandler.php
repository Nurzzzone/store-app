<?php

namespace App\Commands\Product\Handlers;

use App\Commands\Product\ProductRentCommand;
use App\Models\Product;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class ProductRentCommandHandler
{
    public function handle(ProductRentCommand $command): void
    {
        $user = User::query()->findOrFail($command->userId);
        $product = Product::query()->findOrFail($command->productId);

        $activeRental = Rental::query()
            ->where('product_id', $product->id)
            ->where('status', 'active')
            ->where('end_time', '>', now())
            ->first();

        if ($activeRental) {
            throw new \Exception('Product is currently rented.');
        }

        $rentalPrice = $product->rental_price * ($command->duration / 4);

        if ($user->balance < $rentalPrice) {
            throw new \Exception('Insufficient balance.');
        }

        DB::transaction(function () use ($user, $product, $command, $rentalPrice) {
            $user->balance -= $rentalPrice;
            $user->save();

            Rental::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'start_time' => now(),
                'end_time' => now()->addHours($command->duration),
                'unique_code' => Str::uuid(),
            ]);
        });
    }
}
