<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Peminjam\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Redirect ke login jika belum login, atau ke dashboard jika sudah login
    if (auth()->check()) {
        $user = auth()->user();
        $user->load('role');
        $roleName = $user->role->nama_role;
        
        return match($roleName) {
            'peminjam' => redirect()->route('peminjam.dashboard'),
            'admin_bapendik' => redirect()->route('admin.dashboard'),
            'wakil_dekan_2' => redirect()->route('wd.dashboard'),
            'sub_koor' => redirect()->route('subkoor.dashboard'),
            default => redirect()->route('show.login')
        };
    }
    
    return view('welcome');
})->name('home');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk guest (belum login)
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegister')->name('show.register');
    Route::get('/login', 'showLogin')->name('show.login');
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
});