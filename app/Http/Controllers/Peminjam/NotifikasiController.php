<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        // TODO: Ambil notifikasi berdasarkan user login
        return view('peminjam.notifikasi.index');
    }
}
