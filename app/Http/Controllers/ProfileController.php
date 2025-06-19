<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('pages.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username'      => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'birthdate'     => 'required|date',
            'gender'        => 'required|in:male,female,other',
            'address'       => 'required|string|max:1000',
            'city'          => 'required|string|max:255',
            'phone_number'  => 'required|string|max:20',
            'paypal_id'     => 'nullable|string|max:255', // tidak wajib harus email, agar "pepel" tetap valid
            'password'      => 'nullable|string|min:6|confirmed',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->birthdate = $request->birthdate;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->phone_number = $request->phone_number;
        $user->paypal_id = $request->paypal_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
