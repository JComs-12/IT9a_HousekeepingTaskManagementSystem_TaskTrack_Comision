<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Only seed if rooms table is empty — idempotent on repeat deploys
        if (Room::exists()) {
            return;
        }

        $rooms = [];
        foreach (range(101, 110) as $number) {
            $rooms[] = [
                'room_number' => (string) $number,
                'room_type'   => 'Single',
                'status'      => 'Available',
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        Room::insert($rooms);
    }
}
