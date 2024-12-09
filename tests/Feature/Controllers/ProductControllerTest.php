<?php

namespace Feature\Controllers;

use App\Models\Product;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);
    }

    public function testProductPurchaseSuccessful()
    {
        $product = Product::factory()->create();

        $response = $this->post(sprintf('api/v1/products/%s/purchase', $product->id));

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Product successfully purchased!']);
    }

    public function testProductRentSuccessful()
    {
        $product = Product::factory()->create();

        $response = $this->post(sprintf('api/v1/products/%s/rent', $product->id), ['duration' => 4]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Product successfully rented!']);
    }

    public function testGetProductStatusSuccessful()
    {
        $product = Product::factory()->create();

        Rental::factory()->create(['product_id' => $product->id, 'user_id' => $this->user->id]);

        $response = $this->get(sprintf('api/v1/products/%s/status', $product->id));

        $response->assertStatus(200);
        $response->assertJsonFragment(['status' => 'rented']);
    }
}
