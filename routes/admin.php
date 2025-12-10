<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\NotifikasiController;

Route::middleware(['auth', 'role:bapendik'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Approval Peminjaman
    Route::get('/approval', [ApprovalController:: class, 'index'])->name('approval.index');
    Route::post('/approval/{id}/approve', [ApprovalController:: class, 'approve'])->name('approval.approve');
    Route::post('/approval/{id}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
    Route::get('/approval/{id}/detail', [ApprovalController::class, 'show'])->name('approval.show');
    
    // Archive
    Route::get('/archive', [ArchiveController::class, 'index'])->name('archive');
    
    // Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
});