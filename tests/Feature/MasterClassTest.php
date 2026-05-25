<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\CraftType;
use App\Models\MasterClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class MasterClassTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_guest_cannot_access_create_form()
    {
        $response = $this->get('/master-class/create');
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function test_ordinary_user_cannot_access_create_form()
    {
        $user = User::create([
            'fio' => 'Ordinary User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 1,
        ]);

        $response = $this->actingAs($user)->get('/master-class/create');
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function test_master_can_access_create_form()
    {
        $master = User::create([
            'fio' => 'Master User',
            'email' => 'master@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $response = $this->actingAs($master)->get('/master-class/create');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_master_can_create_master_class()
    {
        $master = User::create([
            'fio' => 'Master User',
            'email' => 'master@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $craft = CraftType::create([
            'name' => 'Тестовый вид',
            'description' => 'Описание вида'
        ]);

        $response = $this->actingAs($master)->post('/master-class', [
            'craft_type_id' => $craft->id,
            'title' => 'Новый мастер-класс',
            'description' => 'Подробное описание нового мастер-класса для тестирования',
            'date' => '2026-06-20',
            'time_slot' => '11-13',
            'max_participants' => 15,
            'price' => 2000,
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseHas('master_classes', ['title' => 'Новый мастер-класс']);
    }

    public function test_master_cannot_create_class_without_title()
    {
        $master = User::create([
            'fio' => 'Master User',
            'email' => 'master@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $craft = CraftType::create([
            'name' => 'Тестовый вид',
            'description' => 'Описание вида'
        ]);

        $response = $this->actingAs($master)->post('/master-class', [
            'craft_type_id' => $craft->id,
            'title' => '',
            'description' => 'Подробное описание',
            'date' => '2026-06-20',
            'time_slot' => '11-13',
            'max_participants' => 15,
            'price' => 2000,
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseCount('master_classes', 0);
    }

    public function test_master_cannot_create_class_with_short_title()
    {
        $master = User::create([
            'fio' => 'Master User',
            'email' => 'master@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $craft = CraftType::create([
            'name' => 'Тестовый вид',
            'description' => 'Описание вида'
        ]);

        $response = $this->actingAs($master)->post('/master-class', [
            'craft_type_id' => $craft->id,
            'title' => 'AB',
            'description' => 'Подробное описание',
            'date' => '2026-06-20',
            'time_slot' => '11-13',
            'max_participants' => 15,
            'price' => 2000,
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseCount('master_classes', 0);
    }

    public function test_master_cannot_create_class_with_short_description()
    {
        $master = User::create([
            'fio' => 'Master User',
            'email' => 'master@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $craft = CraftType::create([
            'name' => 'Тестовый вид',
            'description' => 'Описание вида'
        ]);

        $response = $this->actingAs($master)->post('/master-class', [
            'craft_type_id' => $craft->id,
            'title' => 'Новый мастер-класс',
            'description' => 'Короткое',
            'date' => '2026-06-20',
            'time_slot' => '11-13',
            'max_participants' => 15,
            'price' => 2000,
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseCount('master_classes', 0);
    }

    public function test_master_cannot_create_class_with_past_date()
    {
        $master = User::create([
            'fio' => 'Master User',
            'email' => 'master@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $craft = CraftType::create([
            'name' => 'Тестовый вид',
            'description' => 'Описание вида'
        ]);

        $response = $this->actingAs($master)->post('/master-class', [
            'craft_type_id' => $craft->id,
            'title' => 'Новый мастер-класс',
            'description' => 'Подробное описание',
            'date' => '2020-01-01',
            'time_slot' => '11-13',
            'max_participants' => 15,
            'price' => 2000,
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseCount('master_classes', 0);
    }

    public function test_master_cannot_create_class_with_conflicting_time()
    {
        $master = User::create([
            'fio' => 'Master User',
            'email' => 'master@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $craft = CraftType::create([
            'name' => 'Тестовый вид',
            'description' => 'Описание вида'
        ]);

        MasterClass::create([
            'craft_type_id' => $craft->id,
            'master_id' => $master->id,
            'title' => 'Существующий МК',
            'description' => 'Описание существующего мастер-класса',
            'date' => '2026-06-20',
            'time_slot' => '11-13',
            'max_participants' => 10,
            'price' => 1000,
        ]);

        $response = $this->actingAs($master)->post('/master-class', [
            'craft_type_id' => $craft->id,
            'title' => 'Новый мастер-класс',
            'description' => 'Подробное описание',
            'date' => '2026-06-20',
            'time_slot' => '11-13',
            'max_participants' => 15,
            'price' => 2000,
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseCount('master_classes', 1);
    }

    public function test_master_can_edit_own_master_class()
    {
        $master = User::create([
            'fio' => 'Master User',
            'email' => 'master@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $craft = CraftType::create([
            'name' => 'Тестовый вид',
            'description' => 'Описание вида'
        ]);

        $masterClass = MasterClass::create([
            'craft_type_id' => $craft->id,
            'master_id' => $master->id,
            'title' => 'Существующий МК',
            'description' => 'Описание',
            'date' => '2026-06-20',
            'time_slot' => '11-13',
            'max_participants' => 10,
            'price' => 1000,
        ]);

        $response = $this->actingAs($master)->get('/master-class/' . $masterClass->id . '/edit');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_master_cannot_edit_other_master_class()
    {
        $master1 = User::create([
            'fio' => 'Master One',
            'email' => 'master1@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $master2 = User::create([
            'fio' => 'Master Two',
            'email' => 'master2@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $craft = CraftType::create([
            'name' => 'Тестовый вид',
            'description' => 'Описание вида'
        ]);

        $masterClass = MasterClass::create([
            'craft_type_id' => $craft->id,
            'master_id' => $master1->id,
            'title' => 'МК мастера 1',
            'description' => 'Описание',
            'date' => '2026-06-20',
            'time_slot' => '11-13',
            'max_participants' => 10,
            'price' => 1000,
        ]);

        $response = $this->actingAs($master2)->get('/master-class/' . $masterClass->id . '/edit');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_master_can_update_own_master_class()
    {
        $master = User::create([
            'fio' => 'Master User',
            'email' => 'master@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $craft = CraftType::create([
            'name' => 'Тестовый вид',
            'description' => 'Описание вида'
        ]);

        $masterClass = MasterClass::create([
            'craft_type_id' => $craft->id,
            'master_id' => $master->id,
            'title' => 'Старое название',
            'description' => 'Старое описание',
            'date' => '2026-06-20',
            'time_slot' => '11-13',
            'max_participants' => 10,
            'price' => 1000,
        ]);

        $response = $this->actingAs($master)->put('/master-class/' . $masterClass->id, [
            'description' => 'Обновленное описание',
            'price' => 2500,
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseHas('master_classes', [
            'id' => $masterClass->id,
            'description' => 'Обновленное описание',
            'price' => 2500,
        ]);
    }

    public function test_check_slots_returns_occupied_slots()
    {
        $master = User::create([
            'fio' => 'Master User',
            'email' => 'master@test.com',
            'password' => bcrypt('password'),
            'phone' => '+79123456789',
            'role' => 2,
        ]);

        $craft = CraftType::create([
            'name' => 'Тестовый вид',
            'description' => 'Описание вида'
        ]);

        MasterClass::create([
            'craft_type_id' => $craft->id,
            'master_id' => $master->id,
            'title' => 'МК в 11-13',
            'description' => 'Описание',
            'date' => '2026-06-20',
            'time_slot' => '11-13',
            'max_participants' => 10,
            'price' => 1000,
        ]);

        // Принудительно сохраняем в БД
        $this->assertDatabaseHas('master_classes', ['time_slot' => '11-13']);
        
        $response = $this->actingAs($master)->get('/check-slots?date=2026-06-20');
        $this->assertEquals(200, $response->getStatusCode());
        
        $content = json_decode($response->getContent(), true);
        // Проверяем, что в ответе есть ключ '11-13'
        $this->assertArrayHasKey('11-13', $content);
        $this->assertTrue($content['11-13']);
    }
}
