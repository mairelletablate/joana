<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }
}
 function updateSettings(Request $request) {
    $user = auth()->user();

    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        'phone' => 'required|string|max:15',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $user->username = $validated['username'];
    $user->email = $validated['email'];
    $user->phone = $validated['phone'];

    if ($validated['password']) {
        $user->password = bcrypt($validated['password']);
    }

    $user->save();

    return redirect()->route('settings')->with('success', 'Settings updated successfully!');
}
