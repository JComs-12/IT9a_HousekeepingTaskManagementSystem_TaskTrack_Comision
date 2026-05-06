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
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

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
                ->withErrors($validator)
                ->withInput($request->except(['current_password', 'password', 'password_confirmation']))
                ->with('error', 'Please fix the password errors below.');
        }

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password is incorrect!'])
                ->withInput($request->except(['current_password', 'password', 'password_confirmation']))
                ->with('error', 'Please fix the password errors below.');
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}