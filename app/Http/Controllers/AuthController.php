<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_user' => 'required|string|max:255',  // ✅ Fixed
            'no_induk' => 'required|string|max:30|unique:users',
            'no_hp' => 'required|string|max:30',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['role_id'] = 1; // Default:  peminjam

        $user = User::create($validated);

        // Login dengan eager loading role
        Auth::login($user);
        
        // Refresh user dengan relasi role
        $user = User::with('role')->find($user->user_id);
        Auth::setUser($user);

        return redirect()->route('peminjam.dashboard')->with('success', 'Registrasi berhasil! ');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            
            // Eager load role
            $user = User::with('role')->find(Auth::id());
            Auth::setUser($user);
            
            // Redirect berdasarkan role
            $role_id = $user->role_id;
            
            return match($role_id) {
                1 => redirect()->route('peminjam.dashboard'),
                2 => redirect()->route('admin.dashboard'),
                3 => redirect()->route('wd.dashboard'),
                4 => redirect()->route('subkoor.dashboard'),
                default => redirect()->route('peminjam.dashboard')
            };
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth:: logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('show.login')->with('success', 'Logout berhasil!');
    }
}