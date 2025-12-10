<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi:: where('user_id', Auth::id())
            ->with(['peminjaman. ruangan'])
            ->latest('waktu_kirim')
            ->get();
        
        return view('admin.notifikasi.index', compact('notifikasis'));
    }
}