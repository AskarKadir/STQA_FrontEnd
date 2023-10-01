<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Database\Seeder;
use App\Models\User as User;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'              => 'Askar Kadir',
            'email'             => 'admin@gmail.com',
            'password'          => bcrypt('admin'),
            'no_telp'           => '081234567890',
            'username'          => 'admin',
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
            'is_admin'          => 1,
        ]);
        User::create([
            'name'              => 'user',
            'email'             => 'user@gmail.com',
            'password'          => bcrypt('password'),
            'no_telp'           => '0812345327890',
            'username'          => 'user',
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
            'is_admin'          => 0,
        ]);


        User::factory(10)->create();
        Menu::factory(50)->create();
        Order::factory(5)->create();
    }
}