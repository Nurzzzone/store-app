<?php

namespace App\Commands\Rental\Handlers;

use App\Commands\Rental\RentalExtendCommand;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RentalExtendCommandHandler
{
    public function handle(RentalExtendCommand $command)
    {
        $rental = Rental::query()->findOrFail($command->rentalId);

        if ($rental->status !== 'active' || $rental->end_time < now()) {
            throw new \Exception('Rental is not active');
        }

        $totalDuration = $rental->end_time->diffInHours($rental->start_time) + $command->additionalDuration;

        if ($totalDuration > 24) {
            throw new \Exception('Rental duration cannot exceed 24 hours.');
        }

        $user = User::query()->findOrFail($command->userId);
        $product = $rental->product;
        $extensionPrice = $product->rental_price * ($command->additionalDuration / 4);

        if ($user->balance < $extensionPrice) {
            throw new \Exception('Insufficient balance.');
        }

        DB::transaction(function () use ($rental, $user, $extensionPrice, $command) {
            $user->balance -= $extensionPrice;
            $user->save();

            $rental->end_time = $rental->end_time->addHours($command->additionalDuration);
            $rental->save();
        });
    }
}
