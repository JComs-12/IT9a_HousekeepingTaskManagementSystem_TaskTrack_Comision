<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Notifications\ImportantActionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->oldest()->get();
        return view('admin.admins.index', compact('admins'));
    }

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
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:255',
            'birthdate' => 'required|date|before:today',
            'age' => 'required|integer|min:16|max:120',
            'password' => 'required|confirmed|min:8',
        ]);

        $fullName = trim($request->first_name . ' ' . $request->last_name);

        $admin = User::create([
            'name' => $fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        // Create activity log for admin account creation
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action' => 'Admin Account Created',
            'description' => "Admin account '{$fullName}' (Email: {$request->email}) created by " . Auth::user()->name . ".",
            'is_important' => true,
            'subject_type' => 'User',
            'subject_id' => $admin->id,
        ]);

        // Notify all admins about the new admin account
        $admins = User::where('role', 'admin')->where('id', '!=', Auth::id())->get();
        foreach ($admins as $existingAdmin) {
            $existingAdmin->notify(new ImportantActionNotification(
                'Admin Account Created',
                "New admin account '{$fullName}' has been created.",
                Auth::user()->name,
                'admin',
                route('admin.admins.index')
            ));
        }

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin account created successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Only admin accounts can be deleted from here.');
        }

        if ($user->id !== Auth::id()) {
            return redirect()->back()->with('error', 'You can only delete your own admin account.');
        }

        $adminName = $user->name;
        $adminEmail = $user->email;

        // Log the deletion
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action' => 'Admin Account Deleted',
            'description' => "Admin account '{$adminName}' (Email: {$adminEmail}) deleted by " . Auth::user()->name . ".",
            'is_important' => true,
            'subject_type' => 'User',
            'subject_id' => $user->id,
        ]);

        // Notify remaining admins
        $admins = User::where('role', 'admin')->where('id', '!=', $user->id)->get();
        foreach ($admins as $admin) {
            $admin->notify(new ImportantActionNotification(
                'Admin Account Deleted',
                "Admin account '{$adminName}' has been deleted.",
                Auth::user()->name,
                'admin',
                route('admin.admins.index')
            ));
        }

        $user->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Your admin account has been deleted successfully.');
    }
}
