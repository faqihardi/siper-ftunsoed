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
        
        return view('admin.approval.index', compact('peminjamans'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'ruangan.gedung', 'details'])
            ->findOrFail($id);
        
        return view('admin.approval.show', compact('peminjaman'));
    }

    public function approve($id)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id);
            
            // Update status menjadi disetujui bapendik
            $peminjaman->update([
                'status' => 'disetujui bapendik'
            ]);
            
            // Kirim notifikasi ke peminjam
            Notifikasi::create([
                'peminjaman_id' => $peminjaman->peminjaman_id,
                'user_id' => $peminjaman->user_id,
                'pesan' => 'Peminjaman ruangan ' . $peminjaman->ruangan->nama_ruang . ' telah disetujui oleh Bapendik. Menunggu persetujuan dari Subkoor.',
                'status_baca' => 'unread'
            ]);
            
            // Kirim notifikasi ke semua Subkoor (role_id = 4)
            $subkoorUsers = \App\Models\User::where('role_id', 4)->get();
            foreach ($subkoorUsers as $subkoor) {
                Notifikasi::create([
                    'peminjaman_id' => $peminjaman->peminjaman_id,
                    'user_id' => $subkoor->user_id,
                    'pesan' => 'Peminjaman ruangan ' . $peminjaman->ruangan->nama_ruang . ' oleh ' . $peminjaman->user->nama_user . ' telah disetujui Bapendik. Mohon review dan setujui.',
                    'status_baca' => 'unread'
                ]);
            }
            
            // Selalu return JSON untuk POST request
            return response()->json(['success' => true, 'message' => 'Peminjaman berhasil disetujui!']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function reject(Request $request, $id)
    {
        try {
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
                'pesan' => 'Peminjaman ruangan ' . $peminjaman->ruangan->nama_ruang . ' ditolak oleh Bapendik. ' . ($request->catatan_penolakan ?? ''),
                'status_baca' => 'unread'
            ]);
            
            // Selalu return JSON untuk POST request
            return response()->json(['success' => true, 'message' => 'Peminjaman berhasil ditolak!']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}