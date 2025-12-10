<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\Models\Gedung;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    // List semua gedung
    public function index()
    {
        $gedungs = Gedung::with('ruangan')->get();
        return view('peminjam.ruangan.index', compact('gedungs'));
    }

    // List ruangan dalam gedung tertentu
    public function showGedung($gedung_id)
    {
        $gedung = Gedung::with('ruangan')->findOrFail($gedung_id);
        return view('peminjam.ruangan.list', compact('gedung'));
    }

    // Detail ruangan
    public function detail($ruang_id)
    {
        $ruangan = Ruangan::with('gedung')->findOrFail($ruang_id);
        
        // Ambil jadwal peminjaman untuk ruangan ini
        // Hanya yang approved (disetujui bapendik atau disetujui subkoor)
        $jadwals = Peminjaman::where('ruang_id', $ruang_id)
            ->whereIn('status', ['disetujui bapendik', 'disetujui subkoor', 'pending'])
            ->with('user')
            ->orderBy('tanggal_peminjaman', 'asc')
            ->take(10)
            ->get();
        
        return view('peminjam.ruangan.detail', compact('ruangan', 'jadwals'));
    }
}