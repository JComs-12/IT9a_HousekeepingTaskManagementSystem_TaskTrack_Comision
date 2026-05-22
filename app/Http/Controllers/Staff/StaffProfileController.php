<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StaffProfileController extends Controller
{
    public function edit()
    {
        return view('staff.profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $staff = $user->staff;

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:30',
            'address'    => 'required|string|max:255',
            'birthdate'  => 'required|date|before:today',
            'gender'     => 'required|string|in:male,female,other,prefer_not_to_say',
        ]);

        // Auto-calculate age from birthdate (no manual input needed)
        $age = \Carbon\Carbon::parse($request->birthdate)->age;

        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'gender' => $request->gender,
        ]);

        if ($staff) {
            $staff->update([
                'name'       => trim($request->first_name . ' ' . $request->last_name),
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'phone'      => $request->phone,
                'address'    => $request->address,
                'birthdate'  => $request->birthdate,
                'age'        => $age,
                'gender'     => $request->gender,
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // NEW: Avatar upload handler
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return redirect()->back()->with('success', 'Profile picture updated!');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'The new password and confirmation do not match.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'passwordUpdate')
                ->withInput($request->except(['current_password', 'password', 'password_confirmation']))
                ->with('error', 'Please fix the password errors below.');
        }

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password is incorrect!'], 'passwordUpdate')
                ->withInput($request->except(['current_password', 'password', 'password_confirmation']))
                ->with('error', 'Please fix the password errors below.');
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}