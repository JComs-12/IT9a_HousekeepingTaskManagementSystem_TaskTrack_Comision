<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // firstOrCreate prevents duplicate-key errors on repeat deploys
        User::firstOrCreate(
            ['email' => 'test@email.com'],          // search key
            [
                'name'     => 'Test User',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );
    }
}