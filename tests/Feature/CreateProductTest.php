<?php

namespace Tests\Feature;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_authenticated_user_can_create_a_product(): void
    {
        $user = $this->authUser();

        Passport::actingAs($user);

        $response = $this->postJson('/api/v1/products', [
            'name'      => 'Product 1',
            'price'     => 10000,
            'inventory' => 100
        ]);

        $response->assertJsonStructure([
           'data' => ['product' => ['name']]
        ]);

        $response->assertStatus(201);
    }

    public function test_unauthenticated_user_can_not_create_a_product(): void
    {
        $response = $this->postJson('/api/v1/products', [
            'name'      => 'Product 1',
            'price'     => 10000,
            'inventory' => 100
        ]);

        $response->assertUnauthorized();
    }
}
