<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil peminjaman yang perlu approval Bapendik
        // Status: pending atau untuk kelas pengganti
        $peminjamans = Peminjaman::whereIn('status', ['pending', 'diajukan'])
            ->with(['user', 'ruangan. gedung', 'details'])
            ->latest()
            ->get();
        
        return view('admin. dashboard', compact('peminjamans'));
    }
}