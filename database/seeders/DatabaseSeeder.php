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
        // ── Admin user (no-op if already exists) ──────────
        User::firstOrCreate(
            ['email' => 'test@email.com'],
            [
                'name'     => 'Test User',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // ── Rooms 101–110 (no-op if rooms already exist) ──
        $this->call(RoomSeeder::class);
    }
}