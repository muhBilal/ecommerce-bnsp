<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->where('role', 'user')->get();
        return view('dashboard.pages.users.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|unique:users,username,' . $id,
            'password' => 'nullable|min:6',
            'birthdate' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required',
            'city' => 'required',
            'phone_number' => 'required',
            'paypal_id' => 'nullable',
        ]);

        $data = $request->except('_token', '_method');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        DB::table('users')->where('id', $id)->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
