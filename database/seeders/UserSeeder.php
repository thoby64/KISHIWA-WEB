<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user if not exists
        if (!User::where('email', 'admin@kishiwaschool.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@kishiwaschool.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]);
        }

        // Create manager user if not exists
        if (!User::where('email', 'manager@kishiwaschool.com')->exists()) {
            User::create([
                'name' => 'Manager User',
                'email' => 'manager@kishiwaschool.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'is_active' => true,
            ]);
        }

        // Create regular user if not exists
        if (!User::where('email', 'user@kishiwaschool.com')->exists()) {
            User::create([
                'name' => 'Regular User',
                'email' => 'user@kishiwaschool.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
            ]);
        }
    }
}