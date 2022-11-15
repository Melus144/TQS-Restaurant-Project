<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Food;
use App\Models\Recipe;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_statuses')->insert([
            ['status' => 'En espera', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['status' => 'Confirmada', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['status' => 'Cancel·lada', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['status' => 'En procés', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['status' => 'Servida', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['status' => 'Pagada', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
        ]);
        User::factory()->create([
            'firstname' => 'Adri',
            'lastname' => 'Melus',
            'email' => 'adri@tqsproject.com',
            'password' => bcrypt('admin'),
        ]);
        User::factory()->create([
            'firstname' => 'Alex',
            'email' => 'alex@tqsproject.com',
            'password' => bcrypt('admin'),
        ]);
        Recipe::factory()->create([
            'name' => 'Hamburguesa',
            'price' => 5.5,
            'type' => Recipe::TYPE_STARTERS,
            'food_type' => 0,
            'available' => true
        ]);
        Recipe::factory()->create([
            'name' => 'Pizza',
            'price' => 6.5,
            'type' => Recipe::TYPE_MAIN_COURSE,
            'food_type' => 0,
            'available' => true
        ]);
        Recipe::factory()->create([
            'name' => 'Ensalada',
            'price' => 4.5,
            'type' => Recipe::TYPE_FIRST_COURSE,
            'food_type' => 0,
            'available' => true
        ]);
        Recipe::factory()->create([
            'name' => 'Coca',
            'price' => 2.5,
            'type' => Recipe::TYPE_DESERT,
            'food_type' => 0,
            'available' => true
        ]);
        Recipe::factory()->create([
            'name' => 'Coca de xocolata',
            'price' => 3.5,
            'type' => Recipe::TYPE_DESERT,
            'food_type' => 3,
            'available' => true
        ]);
        Recipe::factory()->create([
            'name' => 'Coca de poma',
            'price' => 3.5,
            'type' => Recipe::TYPE_DESERT,
            'food_type' => 3,
            'available' => true
        ]);
        Recipe::factory()->create([
            'name' => 'Pollo asado',
            'price' => 7.5,
            'type' => Recipe::TYPE_MAIN_COURSE,
            'food_type' => 2,
            'available' => true
        ]);
        Food::factory()->create([
            'name' => 'Patata',
            'units' => 'kg',
            'type' => 0
        ]);
        Food::factory()->create([
            'name' => 'Tomate',
            'units' => 'kg',
            'type' => 0
        ]);
        Food::factory()->create([
            'name' => 'Lechuga',
            'units' => 'kg',
            'type' => 0
        ]);
        Food::factory()->create([
            'name' => 'Queso',
            'units' => 'kg',
            'type' => 0
        ]);
        Food::factory()->create([
            'name' => 'Carne',
            'units' => 'kg',
            'type' => 0
        ]);
        Food::factory()->create([
            'name' => 'Pollo',
            'units' => 'kg',
            'type' => 0
        ]);
        Food::factory()->create([
            'name' => 'Pasta',
            'units' => 'kg',
            'type' => 0
        ]);
        Food::factory()->create([
            'name' => 'Cebolla',
            'units' => 'kg',
            'type' => 0
        ]);
        Food::factory()->create([
            'name' => 'Pimiento',
            'units' => 'kg',
            'type' => 0
        ]);
        Food::factory()->create([
            'name' => 'Aceite',
            'units' => 'l',
            'type' => 1
        ]);
        Food::factory()->create([
            'name' => 'Sal',
            'units' => 'kg',
            'type' => 1
        ]);
        Food::factory()->create([
            'name' => 'Azucar',
            'units' => 'kg',
            'type' => 1
        ]);
        Food::factory()->create([
            'name' => 'Harina',
            'units' => 'kg',
            'type' => 1
        ]);
        Food::factory()->create([
            'name' => 'Huevos',
            'units' => 'kg',
            'type' => 1
        ]);
        Food::factory()->create([
            'name' => 'Leche',
            'units' => 'l',
            'type' => 1
        ]);
        Booking::factory()->create([
            'table' => 80,
        ]);
        Booking::factory()->create([
            'table' => 52,
        ]);
        Stock::factory()->create([
            'food_id' => 1,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 2,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 3,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 4,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 5,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 6,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 7,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 8,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 9,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 10,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 11,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 12,
            'quantity' => 100,
        ]);
        Stock::factory()->create([
            'food_id' => 13,
            'quantity' => 100,
        ]);

    }
}
