<?php

namespace App\Commands\Rental;

class RentalExtendCommand
{
    public function __construct(
        public int $userId,
        public int $rentalId,
        public int $additionalDuration
    ) {
    }
}
