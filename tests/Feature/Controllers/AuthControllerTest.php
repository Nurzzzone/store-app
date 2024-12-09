<?php

namespace Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testLoginIsSuccessful(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/v1/login', ['email' => $user->email, 'password' => 'password']);

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->has('token'));
    }

    public function testLogoutIsSuccessful(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->post('/api/v1/logout');

        $response->assertStatus(200);
    }
}
