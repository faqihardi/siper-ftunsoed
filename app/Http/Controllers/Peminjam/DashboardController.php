<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // TODO: Ngambil data peminjaman aktif & riwayat untuk ditampilkan di dashboard
        return view('peminjam.dashboard');
    }
}
