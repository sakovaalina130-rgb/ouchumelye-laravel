<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Виды творчества (без указания ID)
        DB::table('craft_types')->insert([
            [
                'name' => 'Архитектурное моделирование',
                'description' => 'Архитектурное моделирование — это изготовление моделей зданий, сооружений, исторических памятников, а также инженерных и фортификационных сооружений.'
            ],
            [
                'name' => 'Кулинария',
                'description' => 'Кулинария – искусство приготовления пищи. Еда – это топливо, на котором работает организм, и знать об этом топливе, уметь грамотно его использовать должен любой человек.'
            ],
            [
                'name' => 'Резьба по дереву',
                'description' => 'Резьба по дереву - древнейший вид русского народного декоративного искусства. В нашей стране, богатой лесами, дерево всегда было одним из самых любимых материалов.'
            ],
        ]);

        // Получаем ID видов творчества
        $architectId = DB::table('craft_types')->where('name', 'Архитектурное моделирование')->value('id');
        $cookingId = DB::table('craft_types')->where('name', 'Кулинария')->value('id');
        $carvingId = DB::table('craft_types')->where('name', 'Резьба по дереву')->value('id');

        // Пользователи
        DB::table('users')->insert([
            [
                'fio' => 'Иванова Ольга Ивановна',
                'email' => 'master@example.com',
                'password' => Hash::make('password'),
                'phone' => '+79123456789',
                'role' => 2,
                'photo' => 'img/driver-page.png',
            ],
            [
                'fio' => 'Петров Петр Петрович',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'phone' => '+79234567890',
                'role' => 1,
                'photo' => 'img/driver-page.png',
            ],
        ]);

        // Получаем ID ведущего
        $masterId = DB::table('users')->where('email', 'master@example.com')->value('id');

        // Мастер-классы
        DB::table('master_classes')->insert([
            [
                'craft_type_id' => $architectId,
                'master_id' => $masterId,
                'title' => 'Моделирование моделей транспорта',
                'description' => 'Мастер-класс научит основам моделирования различных видов транспортных средств.',
                'date' => '2026-06-05',
                'time_slot' => '15-17',
                'max_participants' => 10,
                'price' => 1500,
            ],
            [
                'craft_type_id' => $architectId,
                'master_id' => $masterId,
                'title' => 'Моделирование зданий и сооружений',
                'description' => 'Опытные педагоги научат моделировать различные элементы малоэтажных жилых и нежилых зданий.',
                'date' => '2026-06-14',
                'time_slot' => '15-17',
                'max_participants' => 8,
                'price' => 2000,
            ],
            [
                'craft_type_id' => $cookingId,
                'master_id' => $masterId,
                'title' => 'Шоколадные поделки',
                'description' => 'Шоколадные фонтаны, фруктовые пальмы, приготовление шоколадных конфет.',
                'date' => '2026-06-10',
                'time_slot' => '13-15',
                'max_participants' => 12,
                'price' => 1200,
            ],
            [
                'craft_type_id' => $cookingId,
                'master_id' => $masterId,
                'title' => 'Приготовление стейков',
                'description' => 'На этом мастер-классе мы расскажем вам всё о стейках.',
                'date' => '2026-06-17',
                'time_slot' => '11-13',
                'max_participants' => 10,
                'price' => 2500,
            ],
            [
                'craft_type_id' => $carvingId,
                'master_id' => $masterId,
                'title' => 'Геометрическая резьба по дереву',
                'description' => 'Мастер-класс для начинающих знакомит с геометрической резьбой.',
                'date' => '2026-06-07',
                'time_slot' => '9-11',
                'max_participants' => 8,
                'price' => 1000,
            ],
            [
                'craft_type_id' => $carvingId,
                'master_id' => $masterId,
                'title' => 'Деревянные игрушки',
                'description' => 'На мастер-классе вы научитесь вырезать фигурки животных из качественных пород дерева.',
                'date' => '2026-06-21',
                'time_slot' => '13-15',
                'max_participants' => 6,
                'price' => 1800,
            ],
        ]);
    }
}
