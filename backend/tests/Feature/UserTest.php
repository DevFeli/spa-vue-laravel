<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_a_user()
    {
        $data = [
            'first_name' => 'Maria Souza',
            'last_name' => 'Maria Souza',
            'email' => 'maria@example.com',
            'password' => Hash::make('123'),
        ];

        $loginResponse = $this->postJson('/api/login', [
            'email' => 'admin@admin',
            'password' => '123',
        ]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $loginResponse->json('access_token'),
        ])->postJson('/api/users', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['email' => 'maria@example.com']);

        $this->assertDatabaseHas('users', ['email' => 'maria@example.com']);
    }
}
