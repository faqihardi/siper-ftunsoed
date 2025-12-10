<?php

namespace App\Http\Controllers\Wd;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::where('status', 'pending')
            ->whereHas('ruangan', function($query) {
                $query->where('nama_ruang', 'LIKE', '%Aula Gedung F%');
            })
            ->with(['user', 'ruangan.gedung', 'details'])
            ->latest()
            ->get();
        
        return view('wd. approval.index', compact('peminjamans'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'ruangan.gedung', 'details'])
            ->findOrFail($id);
        
        return view('wd.approval.show', compact('peminjaman'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->update([
            'status' => 'disetujui wd2'
        ]);
        
        // Kirim notifikasi ke peminjam
        Notifikasi::create([
            'peminjaman_id' => $peminjaman->peminjaman_id,
            'user_id' => $peminjaman->user_id,
            'pesan' => 'Peminjaman Aula Gedung F telah disetujui oleh Wakil Dekan II.',
            'status_baca' => 'unread'
        ]);
        
        // TODO: Kirim notifikasi ke Subkoor untuk final approval
        
        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'nullable|string|max:500'
        ]);
        
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->update([
            'status' => 'ditolak wd2',
            'notes' => $request->catatan_penolakan
        ]);
        
        Notifikasi::create([
            'peminjaman_id' => $peminjaman->peminjaman_id,
            'user_id' => $peminjaman->user_id,
            'pesan' => 'Peminjaman Aula Gedung F ditolak oleh Wakil Dekan II. ' . ($request->catatan_penolakan ?? ''),
            'status_baca' => 'unread'
        ]);
        
        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak!');
    }
}