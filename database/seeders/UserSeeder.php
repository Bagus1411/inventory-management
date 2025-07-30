<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(5)->create([
            // 'name' => 'Test User',
            // 'email' => 'test@example.com',
            // 'password' => 'password'
        ]);
    }
}
