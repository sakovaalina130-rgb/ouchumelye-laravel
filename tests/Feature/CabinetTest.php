<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CabinetTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_cabinet()
    {
        $response = $this->get('/cabinet');
        // Неавторизованный должен быть перенаправлен на логин
        $response->assertStatus(302);
        $this->assertStringContainsString('/login', $response->headers->get('Location'));
    }

    public function test_authenticated_user_can_access_cabinet()
    {
        $user = User::create([
            'fio' => 'Test User',
            'email' => 'test@cabinet.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 1,
        ]);

        $response = $this->actingAs($user)->get('/cabinet');
        $response->assertStatus(200);
    }

    public function test_ordinary_user_cannot_see_master_controls()
    {
        $user = User::create([
            'fio' => 'Test User',
            'email' => 'test@cabinet.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 1, // Обычный пользователь
        ]);

        $response = $this->actingAs($user)->get('/cabinet');
        $response->assertStatus(200);
        // Обычный пользователь НЕ должен видеть кнопку "Добавить мастер-класс"
        $response->assertDontSee('Добавить мастер-класс');
    }

    public function test_master_can_see_master_controls()
    {
        $user = User::create([
            'fio' => 'Master User',
            'email' => 'master@cabinet.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2, // Ведущий
        ]);

        $response = $this->actingAs($user)->get('/cabinet');
        $response->assertStatus(200);
        // Ведущий ДОЛЖЕН видеть кнопку "Добавить мастер-класс"
        $response->assertSee('Добавить мастер-класс');
    }
}
