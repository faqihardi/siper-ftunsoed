<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    // List semua gedung
    public function index()
    {
        // TODO: Ambil semua gedung
        return view('peminjam.ruangan.index');
    }

    // List ruangan dalam gedung tertentu
    public function showGedung($gedung_id)
    {
        // TODO: Ambil data ruangan berdasarkan gedung_id
        return view('peminjam.ruangan.list', compact('gedung_id'));
    }

    // Detail ruangan (opsional)
    public function detail($ruang_id)
    {
        // TODO: Ambil detail ruangan
        return view('peminjam.ruangan.detail', compact('ruang_id'));
    }
}
