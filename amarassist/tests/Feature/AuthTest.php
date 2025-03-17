<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Teste User',
            'email' => 'teste@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);
        $token = auth()->attempt(['email' => $user->email, 'password' => 'password123']);

        $response = $this->postJson('/api/logout', [], ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200);
    }
}
