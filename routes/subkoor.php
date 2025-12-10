<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Subkoor\DashboardController;
use App\Http\Controllers\Subkoor\ApprovalController;
use App\Http\Controllers\Subkoor\ArchiveController;
use App\Http\Controllers\Subkoor\NotifikasiController;

Route::middleware(['auth', 'role:sub_koor'])->prefix('subkoor')->name('subkoor.')->group(function () {
    // Dashboard - Final Approval
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Approval Peminjaman (Final)
    Route::get('/approval', [ApprovalController::class, 'index'])->name('approval.index');
    Route::post('/approval/{id}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::post('/approval/{id}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
    Route::get('/approval/{id}/detail', [ApprovalController::class, 'show'])->name('approval.show');
    
    // Archive
    Route::get('/archive', [ArchiveController::class, 'index'])->name('archive');
    
    // Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
});