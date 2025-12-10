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
            'nama_user' => '|required|string|max:255',
            'no_induk' => '|required|string|max:30|unique:users',
            'no_hp' => '|required|string|max:30',
            'email' => '|required|email|max:100',
            'password' => '|required|string|min:8|confirmed',
        ]);

        $validated['role_id'] = 1;

        $user = User::create($validated);

        Auth::login($user);

        return redirect()->route('peminjam.dashboard');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->route('peminjam.dashboard');
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
