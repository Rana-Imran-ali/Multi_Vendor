<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_as_customer()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'customer',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         'user' => ['id', 'name', 'email', 'role'],
                         'token'
                     ]
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role' => 'customer',
        ]);
    }

    public function test_user_can_register_as_vendor()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Vendor Store',
            'email' => 'vendor@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'vendor',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => 'vendor@example.com',
            'role' => 'vendor',
        ]);
    }

    public function test_registration_fails_without_required_fields()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'testlogin@example.com',
            'password' => Hash::make('securepassword'),
            'role' => 'customer'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'testlogin@example.com',
            'password' => 'securepassword',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'user',
                         'token'
                     ]
                 ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'testlogin2@example.com',
            'password' => Hash::make('securepassword'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'testlogin2@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_access_profile()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson('/api/user');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'email' => $user->email,
                 ]);
    }
    
    public function test_unauthenticated_user_cannot_access_profile()
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }

    public function test_user_can_logout()
    {
        // For logout, we actually need a plainTextToken to hit the DB rather than Sanctum::actingAs which mocks it without a DB token model
        $user = User::factory()->create([
            'password' => Hash::make('password')
        ]);
        
        $loginResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        
        $token = $loginResponse->json('data.token');

        $logoutResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $logoutResponse->assertStatus(200);
        
        // Assert token is deleted
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id
        ]);
    }
}
