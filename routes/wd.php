<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Wd\DashboardController;
use App\Http\Controllers\Wd\ApprovalController;
use App\Http\Controllers\Wd\ArchiveController;
use App\Http\Controllers\Wd\NotifikasiController;

Route::middleware(['auth', 'role:wadek2'])->prefix('wd')->name('wd.')->group(function () {
    // Dashboard - Khusus Aula Gedung F
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Approval Peminjaman Aula Gedung F
    Route::get('/approval', [ApprovalController::class, 'index'])->name('approval.index');
    Route::post('/approval/{id}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::post('/approval/{id}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
    Route::get('/approval/{id}/detail', [ApprovalController:: class, 'show'])->name('approval.show');
    
    // Archive
    Route::get('/archive', [ArchiveController::class, 'index'])->name('archive');
    
    // Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
});