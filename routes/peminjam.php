<?php

use illuminate\Support\Facades\Route;
use App\Http\Controllers\Peminjam\DashboardController;
use App\Http\Controllers\Peminjam\PeminjamanController;
use App\Http\Controllers\Peminjam\RuanganController;
use App\Http\Controllers\Peminjam\NotifikasiController;

Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('peminjam')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/ajuan', [PeminjamanController::class, 'create'])->name('ajuan.create');
    Route::post('/ajuan/step1', [PeminjamanController::class, 'storeStep1'])->name('ajuan.storeStep1');

    Route::get('/ajuan/step2/{peminjaman_id}', [PeminjamanController::class, 'createStep2'])->name('ajuan.step2');
    Route::post('/ajuan/step2/{peminjaman_id}', [PeminjamanController::class, 'createStep2'])->name('ajuan.step2');
    
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::get('/ruangan/gedung/{gedung_id}', [RuanganController::class, 'showGedung'])->name('ruangan.showGedung');
    Route::get('/ruangan/detail/{ruang_id}', [RuanganController::class, 'detail'])->name('ruangan.detail');

    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
});