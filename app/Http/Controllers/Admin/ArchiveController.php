<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        // Ambil peminjaman yang sudah diproses (approved atau rejected)
        $archives = Peminjaman::whereIn('status', [
                'disetujui bapendik',
                'disetujui subkoor',
                'ditolak bapendik',
                'ditolak subkoor'
            ])
            ->with(['user', 'ruangan.gedung'])
            ->latest()
            ->get();
        
        return view('admin.archive', compact('archives'));
    }
}