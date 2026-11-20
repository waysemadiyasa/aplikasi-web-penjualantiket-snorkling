<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kaitravel.com'],
            [
                'name' => 'Administrator KAI TRAVEL',
                'password' => Hash::make('KaiTravel@123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}