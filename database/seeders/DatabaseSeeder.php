<?php

namespace Database\Seeders;

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
    }
}
