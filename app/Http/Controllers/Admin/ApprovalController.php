<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::where('status', 'pending')
            ->with(['user', 'ruangan.gedung', 'details'])
            ->latest()
            ->get();
        
        return view('admin.approval. index', compact('peminjamans'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'ruangan.gedung', 'details'])
            ->findOrFail($id);
        
        return view('admin.approval.show', compact('peminjaman'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman:: findOrFail($id);
        
        // Update status berdasarkan jenis peminjaman
        // Jika kelas pengganti, langsung approved_final
        // Jika ruangan biasa atau aula, ke status approved_bapendik
        $peminjaman->update([
            'status' => 'disetujui bapendik'
        ]);
        
        // Kirim notifikasi ke peminjam
        Notifikasi::create([
            'peminjaman_id' => $peminjaman->peminjaman_id,
            'user_id' => $peminjaman->user_id,
            'pesan' => 'Peminjaman ruangan ' . $peminjaman->ruangan->nama_ruang . ' telah disetujui oleh Bapendik.',
            'status_baca' => 'unread'
        ]);
        
        // Jika bukan aula gedung F, kirim notifikasi ke Subkoor
        if ($peminjaman->ruangan->nama_ruang !== 'Aula Gedung F') {
            // TODO: Kirim notifikasi ke Subkoor
        }
        
        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'nullable|string|max:500'
        ]);
        
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->update([
            'status' => 'ditolak bapendik',
            'notes' => $request->catatan_penolakan
        ]);
        
        // Kirim notifikasi ke peminjam
        Notifikasi::create([
            'peminjaman_id' => $peminjaman->peminjaman_id,
            'user_id' => $peminjaman->user_id,
            'pesan' => 'Peminjaman ruangan ' . $peminjaman->ruangan->nama_ruang . ' ditolak oleh Bapendik.  ' . ($request->catatan_penolakan ??  ''),
            'status_baca' => 'unread'
        ]);
        
        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak!');
    }
}