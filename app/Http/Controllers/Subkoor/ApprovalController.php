<?php

namespace App\Http\Controllers\Subkoor;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::whereIn('status', [
                'disetujui bapendik',
                'disetujui wd2'
            ])
            ->with(['user', 'ruangan.gedung', 'details'])
            ->latest()
            ->get();
        
        return view('subkoor.approval.index', compact('peminjamans'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'ruangan. gedung', 'details'])
            ->findOrFail($id);
        
        return view('subkoor.approval.show', compact('peminjaman'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman:: findOrFail($id);
        
        // Final approval dari Subkoor
        $peminjaman->update([
            'status' => 'disetujui subkoor'
        ]);
        
        Notifikasi::create([
            'peminjaman_id' => $peminjaman->peminjaman_id,
            'user_id' => $peminjaman->user_id,
            'pesan' => 'Peminjaman ruangan ' . $peminjaman->ruangan->nama_ruang .  ' telah disetujui final oleh Subkoor.  Silakan gunakan ruangan sesuai jadwal.',
            'status_baca' => 'unread'
        ]);
        
        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui (Final)!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'nullable|string|max:500'
        ]);
        
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->update([
            'status' => 'ditolak subkoor',
            'notes' => $request->catatan_penolakan
        ]);
        
        Notifikasi:: create([
            'peminjaman_id' => $peminjaman->peminjaman_id,
            'user_id' => $peminjaman->user_id,
            'pesan' => 'Peminjaman ruangan ' . $peminjaman->ruangan->nama_ruang . ' ditolak oleh Subkoor. ' . ($request->catatan_penolakan ?? ''),
            'status_baca' => 'unread'
        ]);
        
        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak!');
    }
}