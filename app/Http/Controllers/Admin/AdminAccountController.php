<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Notifications\ImportantActionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:255',
            'birthdate' => 'required|date|before:today',
            'age' => 'required|integer|min:18|max:120',
            'gender' => 'required|in:male,female,other,prefer_not_to_say',
        ]);

        $fullName = trim($request->first_name.' '.$request->last_name);

        $admin = User::create([
            'name' => $fullName,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        activity_log('Admin Account Created', "Administrator '{$fullName}' was created.");

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $recipient) {
            if ($recipient->id === $admin->id) {
                continue;
            }
            $recipient->notify(new ImportantActionNotification(
                'Admin Account Created',
                "Administrator '{$fullName}' was added to the system.",
                auth()->user()->name,
                'admin',
                route('admin.admins.create')
            ));
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Admin account created successfully!');
    }
}
