<?php

namespace App\Http\Controllers\Subkoor;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil peminjaman yang sudah disetujui Bapendik atau WD2
        // Menunggu final approval dari Subkoor
        $peminjamans = Peminjaman::whereIn('status', [
                'disetujui bapendik',
                'disetujui wd2'
            ])
            ->with(['user', 'ruangan.gedung', 'details'])
            ->latest()
            ->get();
        
        return view('subkoor.dashboard', compact('peminjamans'));
    }
}