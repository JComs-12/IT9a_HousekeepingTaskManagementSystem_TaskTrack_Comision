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
                'name'       => 'Test Admin',
                'first_name' => 'Test',
                'last_name'  => 'Admin',
                'phone'      => '09000000000',
                'address'    => '123 Admin Street',
                'birthdate'  => '1990-01-01',
                'age'        => 35,
                'gender'     => 'male',
                'password'   => Hash::make('password'),
                'role'       => 'admin',
            ]
        );

        // ── Rooms 101–110 (no-op if rooms already exist) ──
        $this->call(RoomSeeder::class);
    }
}