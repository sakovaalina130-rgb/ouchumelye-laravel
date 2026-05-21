<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CraftType;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CraftTest extends TestCase
{
    use RefreshDatabase;

    public function test_craft_page_displays_correct_info()
    {
        $craft = CraftType::create([
            'name' => 'Тестовый вид',
            'description' => 'Тестовое описание'
        ]);

        $response = $this->get('/craft/' . $craft->id);
        
        $response->assertStatus(200);
        $response->assertSee('Тестовый вид');
    }

    public function test_craft_page_returns_404_for_invalid_id()
    {
        $response = $this->get('/craft/99999');
        $response->assertStatus(404);
    }

    public function test_guest_cannot_see_register_button_when_no_auth()
    {
        $craft = CraftType::create(['name' => 'Тест', 'description' => 'Описание']);
        $master = User::create([
            'fio' => 'Master',
            'email' => 'master@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);
        
        $masterClass = MasterClass::create([
            'craft_type_id' => $craft->id,
            'master_id' => $master->id,
            'title' => 'Тестовый МК',
            'description' => 'Описание',
            'date' => '2026-06-15',
            'time_slot' => '9-11',
            'max_participants' => 10,
            'price' => 1000,
        ]);

        // Неавторизованный пользователь НЕ должен видеть кнопку "Записаться"
        $response = $this->get('/craft/' . $craft->id);
        $response->assertDontSee('Записаться');
    }

    public function test_authenticated_user_can_see_register_button()
    {
        $user = User::create([
            'fio' => 'Test User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 1,
        ]);

        $craft = CraftType::create(['name' => 'Тест', 'description' => 'Описание']);
        $master = User::create([
            'fio' => 'Master',
            'email' => 'master2@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);
        
        $masterClass = MasterClass::create([
            'craft_type_id' => $craft->id,
            'master_id' => $master->id,
            'title' => 'Тестовый МК',
            'description' => 'Описание',
            'date' => '2026-06-15',
            'time_slot' => '9-11',
            'max_participants' => 10,
            'price' => 1000,
        ]);

        $response = $this->actingAs($user)->get('/craft/' . $craft->id);
        // Авторизованный пользователь ДОЛЖЕН видеть кнопку "Записаться"
        $response->assertSee('Записаться');
    }
}
