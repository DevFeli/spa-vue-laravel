<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_a_product()
    {
        $data = [
            'title' => 'Produto teste',
            'sale_price' => 1,
            'cost_price' => 1 * 1.1,
            'description' => 'Exemplo',
            'is_active' => 1,
        ];

        $loginResponse = $this->postJson('/api/login', [
            'email' => 'admin@admin',
            'password' => '123',
        ]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $loginResponse->json('access_token'),
        ])->postJson('/api/products', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Produto teste']);

        $this->assertDatabaseHas('products', ['title' => 'Produto teste']);
    }
}
