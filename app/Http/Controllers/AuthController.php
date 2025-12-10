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
            'nama_user' => 'required|string|max:255',
            'no_induk' => 'required|string|max:30|unique:users',
            'no_hp' => 'required|string|max:30',
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['role_id'] = 1; // peminjam

        $user = User::create($validated);

        // Login dengan eager loading role
        Auth::login($user);
        
        // Refresh user instance dengan relasi role
        $user = User::with('role')->find($user->user_id);
        Auth::setUser($user);

        return redirect()->route('peminjam.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            
            // Eager load role untuk memastikan relasi tersedia
            $user = User::with('role')->find(Auth::id());
            Auth::setUser($user);

            return redirect()->route('peminjam.dashboard')->with('success', 'Login berhasil!');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Maaf, kredensial Anda salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('show.login');
    }
}
