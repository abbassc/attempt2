<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@nahejali.com',
            'password' => Hash::make('admin123'),
            'phone' => '1234567890',
            'location' => 'Beirut',
            'role' => 'admin'
        ]);
    }
} 