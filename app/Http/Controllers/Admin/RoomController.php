<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Room types used in dropdowns across create/edit
    public static $roomTypes = [
        'Single', 'Double', 'Twin', 'Suite', 'Deluxe', 'Family', 'Presidential'
    ];

    public function index(Request $request)
    {
        $query = Room::latest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                  ->orWhere('room_type',   'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status') && in_array($request->status, ['available','occupied','maintenance'])) {
            $query->where('status', $request->status);
        }

        $rooms = $query->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $roomTypes = self::$roomTypes;
        return view('admin.rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number',
            'room_type'   => 'required|string|max:255',
            'status'      => 'required|in:available,occupied,maintenance',
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room added successfully!');
    }

    public function edit(Room $room)
    {
        $roomTypes = self::$roomTypes;
        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            // Exclude current room's id from the unique check
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'room_type'   => 'required|string|max:255',
            'status'      => 'required|in:available,occupied,maintenance',
        ]);

        $room->update($request->all());

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room updated successfully!');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully!');
    }
}