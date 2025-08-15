<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@shopease.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create wallet for admin
        Wallet::create([
            'user_id' => $admin->id,
            'balance' => 1000.00,
        ]);

        // Create a regular user for testing
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@shopease.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create wallet for regular user
        Wallet::create([
            'user_id' => $user->id,
            'balance' => 500.00,
        ]);
    }
}
