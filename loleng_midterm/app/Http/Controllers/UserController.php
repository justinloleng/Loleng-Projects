<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Show register form
    public function showRegister()
    {
        return view('user.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::insert('INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', [
            $request->name,
            $request->email,
            Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    // Show login form
    public function showLogin()
    {
        return view('user.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::selectOne('SELECT * FROM users WHERE email = ?', [$request->email]);

        if ($user && Hash::check($request->password, $user->password)) {
            // Manually authenticate the user
            Auth::loginUsingId($user->id);

            return redirect()->route('threads.index');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }


    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
