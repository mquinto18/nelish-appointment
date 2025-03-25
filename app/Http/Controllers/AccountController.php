<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // Update Account Details
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'birth_date' => 'nullable|date',
            'mobile_number' => 'nullable|string|max:15',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'mobile_number' => $request->mobile_number,
        ]);
        notify()->success('Profile change successfully!');
        return redirect()->back()->with('success', 'Account details updated successfully.');
    }


    public function password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }
        // Update the password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        notify()->success('Password updated successfully!');
        return redirect()->back()->with('success', 'Password changed successfully!');
    }
}
