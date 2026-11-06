<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Sign in to TodoApp');
    }

    public function test_user_can_register_and_is_redirected_to_dashboard(): void
    {
        $response = $this->post('/register', [
            'name' => 'Alice Developer',
            'email' => 'alice@example.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'alice@example.com',
            'name' => 'Alice Developer',
        ]);
    }

    public function test_user_can_authenticate_with_valid_credentials(): void
    {
        $user = User::create([
            'name' => 'Bob Test',
            'email' => 'bob@example.com',
            'password' => Hash::make('secret1234'),
        ]);

        $response = $this->post('/login', [
            'email' => 'bob@example.com',
            'password' => 'secret1234',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    public function test_user_cannot_authenticate_with_invalid_password(): void
    {
        User::create([
            'name' => 'Bob Test',
            'email' => 'bob@example.com',
            'password' => Hash::make('secret1234'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'bob@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }

    public function test_user_can_logout(): void
    {
        $user = User::create([
            'name' => 'Charlie Test',
            'email' => 'charlie@example.com',
            'password' => Hash::make('secret1234'),
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}

