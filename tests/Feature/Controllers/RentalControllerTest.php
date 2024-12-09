<?php

namespace Feature\Controllers;

use App\Models\Product;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RentalControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testRentalExtensionSuccessful(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $rental = Rental::factory()->create(['product_id' => $product->id, 'user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->post(sprintf('/api/v1/rentals/%s/extend', $rental->id), ['duration' => 4]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Rental extended successfully!']);
    }
}
