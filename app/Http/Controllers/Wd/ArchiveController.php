<?php

namespace App\Http\Controllers\Wd;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = Peminjaman::whereIn('status', [
                'disetujui wd2',
                'disetujui subkoor',
                'ditolak wd2'
            ])
            ->whereHas('ruangan', function($query) {
                $query->where('nama_ruang', 'LIKE', '%Aula Gedung F%');
            })
            ->with(['user', 'ruangan.gedung'])
            ->latest()
            ->get();
        
        return view('wd.archive', compact('archives'));
    }
}