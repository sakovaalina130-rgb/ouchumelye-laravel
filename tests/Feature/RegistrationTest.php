<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\CraftType;
use App\Models\MasterClass;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_guest_cannot_see_confirm_page()
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

        $response = $this->get('/confirm/' . $masterClass->id);
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_see_confirm_page()
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

        $response = $this->actingAs($user)->get('/confirm/' . $masterClass->id);
        $response->assertStatus(200);
        $response->assertSee($masterClass->title);
    }

    public function test_user_cannot_register_twice()
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
            'max_participants' => 2,
            'price' => 1000,
        ]);

        $this->actingAs($user);
        
        $this->post('/register-master-class', ['master_class_id' => $masterClass->id]);
        $response = $this->post('/register-master-class', ['master_class_id' => $masterClass->id]);
        
        $response->assertSessionHas('error');
        $this->assertEquals(1, Registration::count());
    }
}
