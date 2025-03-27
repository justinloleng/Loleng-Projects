<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showRegister()
    {
        return view('user.register');
    }

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

    public function showLogin()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::selectOne('SELECT * FROM users WHERE email = ?', [$request->email]);

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::loginUsingId($user->id);

            return redirect()->route('threads.index');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }


    public function edit()
    {
        $user = Auth::user(); // da use of this to avoid session errors because it stores the infor thre then fetches the logged user details
        return view('user.edit', compact('user'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($request->password) {
            DB::update('UPDATE users SET name = ?, email = ?, password = ?, updated_at = NOW() WHERE id = ?', [
                $request->name,
                $request->email,
                Hash::make($request->password),
                $user->id,
            ]);
        } else {
            DB::update('UPDATE users SET name = ?, email = ?, updated_at = NOW() WHERE id = ?', [
                $request->name,
                $request->email,
                $user->id,
            ]);
        }

        return redirect()->route('threads.index')->with('success', 'Profile updated successfully.');
    }


    public function destroy()
    {
        $user = Auth::user();

        DB::delete('DELETE FROM users WHERE id = ?', [$user->id]);

        Auth::logout();
        return redirect()->route('login')->with('success', 'Account deleted successfully.');
    }
    public function username()
    {
        $user = auth()->user();
        return view('', compact('user'));
    }
}
