<?php

namespace App\Http\Controllers\Wd;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil peminjaman KHUSUS Aula Gedung F yang pending
        $peminjamans = Peminjaman::where('status', 'pending')
            ->whereHas('ruangan', function($query) {
                $query->where('nama_ruang', 'LIKE', '%Aula Gedung F%');
            })
            ->with(['user', 'ruangan. gedung', 'details'])
            ->latest()
            ->get();
        
        return view('wd. dashboard', compact('peminjamans'));
    }
}