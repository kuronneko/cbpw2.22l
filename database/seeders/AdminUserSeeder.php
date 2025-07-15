<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'avatar' => 'default-avatar.png',
            'type' => 5, // Using type field for admin designation
            'created_at' => now(),
            'updated_at' => now(),
            'last_login_ip' => '',
            'last_login_at' => now(),
        ]);
    }
}
