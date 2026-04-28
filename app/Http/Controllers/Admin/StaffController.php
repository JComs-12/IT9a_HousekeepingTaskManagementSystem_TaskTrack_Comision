<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Staff;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::oldest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name',  'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status') && in_array($request->status, ['active','inactive'])) {
            $query->where('status', $request->status);
        }

        $staff = $query->get();
        $tasks = \App\Models\Task::with(['room', 'staff'])->latest()->get();
        return view('admin.staff.index', compact('staff', 'tasks'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:staff,email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'phone'    => 'required|string|max:20',
            'status'   => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($request) {
            $staff = Staff::create([
                'name'   => $request->name,
                'email'  => $request->email,
                'phone'  => $request->phone,
                'status' => $request->status,
            ]);

            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'staff',
                'staff_id' => $staff->id,
            ]);
        });

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff added successfully!');
    }

    public function destroy(Staff $staff)
    {
        DB::transaction(function () use ($staff) {
            User::where('staff_id', $staff->id)->delete();
            $staff->delete();
        });

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff deleted successfully!');
    }

    public function show(Staff $staff)
    {
        // Fixed: use pivot relationship instead of removed staff_id column
        $tasks = Task::with('room')
            ->whereHas('staff', fn($q) => $q->where('staff.id', $staff->id))
            ->latest()
            ->get();

        // Get the linked user (for avatar)
        $user = User::where('staff_id', $staff->id)->first();

        return view('admin.staff.show', compact('staff', 'tasks', 'user'));
    }
}