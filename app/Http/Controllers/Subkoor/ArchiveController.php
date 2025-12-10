<?php

namespace App\Http\Controllers\Subkoor;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = Peminjaman::whereIn('status', [
                'disetujui subkoor',
                'ditolak subkoor'
            ])
            ->with(['user', 'ruangan.gedung'])
            ->latest()
            ->get();
        
        return view('subkoor.archive', compact('archives'));
    }
}