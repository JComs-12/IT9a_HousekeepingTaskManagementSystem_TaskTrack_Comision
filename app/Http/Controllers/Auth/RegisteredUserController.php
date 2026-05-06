<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Staff;
use App\Models\User;
use App\Notifications\ImportantActionNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date', 'before:today'],
            'age' => ['required', 'integer', 'min:16', 'max:120'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $fullName = trim($request->first_name.' '.$request->last_name);

        $staff = Staff::create([
            'name' => $fullName,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'status' => 'active',
        ]);

        $user = User::create([
            'name' => $fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
            'staff_id' => $staff->id,
        ]);

        // Create activity log for staff account creation
        ActivityLog::create([
            'user_id' => $user->id,
            'role' => 'staff',
            'action' => 'Staff Account Created',
            'description' => "Staff member '{$fullName}' (Email: {$request->email}) registered successfully.",
            'is_important' => true,
            'subject_type' => 'Staff',
            'subject_id' => $staff->id,
        ]);

        // Notify all admins about the new staff account
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ImportantActionNotification(
                'Staff Account Created',
                "New staff member '{$fullName}' has registered.",
                $fullName,
                'staff'
            ));
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('staff.dashboard');
    }
}
