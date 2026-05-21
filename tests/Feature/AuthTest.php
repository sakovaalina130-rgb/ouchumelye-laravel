<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'fio' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '+79123456789',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_cannot_register_with_invalid_email()
    {
        $response = $this->post('/register', [
            'fio' => 'Test User',
            'email' => 'invalid-email',
            'phone' => '+79123456789',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseMissing('users', ['email' => 'invalid-email']);
    }

    public function test_user_cannot_register_with_short_password()
    {
        $response = $this->post('/register', [
            'fio' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '+79123456789',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }

    public function test_user_cannot_register_with_mismatched_passwords()
    {
        $response = $this->post('/register', [
            'fio' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '+79123456789',
            'password' => 'password123',
            'password_confirmation' => 'password456',
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }

    public function test_user_cannot_login_with_wrong_password()
    {
        $user = User::create([
            'fio' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 1,
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_user_cannot_login_with_nonexistent_email()
    {
        $response = $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ]);

        $this->assertEquals(302, $response->getStatusCode());
    }
}
