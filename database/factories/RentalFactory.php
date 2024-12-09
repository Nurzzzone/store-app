<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class RentalFactory extends Factory
{
    public function definition(): array
    {
        $startTime = Carbon::now();
        $endTime = $startTime->addHours($this->faker->randomElement([4, 8, 12, 24]));

        return [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'unique_code' => Str::uuid()->toString(),
        ];
    }
}

