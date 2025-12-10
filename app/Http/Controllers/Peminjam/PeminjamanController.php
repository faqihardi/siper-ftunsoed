<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeminjamanDetail;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // Step 1: Form ajuan utama
    public function create()
    {
        $ruangans = Ruangan::with('gedung')->orderBy('nama_ruang')->get();
        return view('peminjam.peminjaman.step1', compact('ruangans'));
    }

    // Step 1:  Simpan data dasar
    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'ruang_id' => 'required|exists:ruangans,ruang_id',
            'tanggal_peminjaman' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_peminjaman',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'tujuan' => 'required|string|max:255',
            'detail_kegiatan' => 'required|string',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Hitung durasi (dalam hari)
        $startDate = Carbon::parse($validated['tanggal_peminjaman']);
        $endDate = Carbon::parse($validated['tanggal_selesai']);
        $durasi = $startDate->diffInDays($endDate) + 1;

        // Upload dokumen pendukung jika ada
        $dokumenPath = null;
        if ($request->hasFile('dokumen_pendukung')) {
            $dokumenPath = $request->file('dokumen_pendukung')->store('dokumen_peminjaman', 'public');
        }

        // Simpan data peminjaman
        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'ruang_id' => $validated['ruang_id'],
            'tanggal_peminjaman' => $validated['tanggal_peminjaman'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'durasi' => $durasi,
            'tujuan' => $validated['tujuan'],
            'detail_kegiatan' => $validated['detail_kegiatan'],
            'dokumen_pendukung' => $dokumenPath,
            'status' => 'draft', // Status awal masih draft
            'notes' => null,  // ✅ Tambahkan ini! 
        ]);

        return redirect()
            ->route('peminjam.ajuan.step2', $peminjaman->peminjaman_id)
            ->with('success', 'Data peminjaman berhasil disimpan.  Silakan isi detail per hari.');
    }

    // Step 2: Halaman mengisi detail sesuai durasi
    public function createStep2($peminjaman_id)
    {
        $peminjaman = Peminjaman::with('ruangan.gedung')->findOrFail($peminjaman_id);
        
        // Cek ownership
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hitung hari ke berapa
        $existingDetails = PeminjamanDetail::where('peminjaman_id', $peminjaman_id)->count();
        $currentDay = $existingDetails + 1;

        // Kalkulasi default date untuk hari ini
        $startDate = Carbon::parse($peminjaman->tanggal_peminjaman);
        $defaultDate = $startDate->copy()->addDays($existingDetails)->format('Y-m-d');

        return view('peminjam.peminjaman.step2', compact('peminjaman', 'currentDay', 'defaultDate'));
    }

    // Step 2: Simpan detail harian
    public function storeStep2(Request $request, $peminjaman_id)
    {
        $peminjaman = Peminjaman::findOrFail($peminjaman_id);
        
        // Cek ownership
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'hari' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Cek bentrokan jadwal
        $conflict = PeminjamanDetail::where('peminjaman_id', '!=', $peminjaman_id)
            ->whereHas('peminjaman', function($q) use ($peminjaman) {
                $q->where('ruang_id', $peminjaman->ruang_id)
                  ->whereIn('status', ['pending', 'disetujui bapendik', 'disetujui subkoor']);
            })
            ->where('tanggal', $validated['tanggal'])
            ->where(function($q) use ($validated) {
                $q->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhere(function($q2) use ($validated) {
                      $q2->where('jam_mulai', '<=', $validated['jam_mulai'])
                         ->where('jam_selesai', '>=', $validated['jam_selesai']);
                  });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'tanggal' => 'Ruangan sudah dipakai pada tanggal dan waktu tersebut.'
            ])->withInput();
        }

        // Simpan detail hari ini
        PeminjamanDetail::create([
            'peminjaman_id' => $peminjaman_id,
            'tanggal' => $validated['tanggal'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
        ]);

        // Cek apakah sudah semua hari diisi
        $totalDetails = PeminjamanDetail::where('peminjaman_id', $peminjaman_id)->count();
        
        if ($totalDetails >= $peminjaman->durasi) {
            // Update status jadi pending (siap untuk di-approve)
            $peminjaman->update(['status' => 'pending']);
            
            return redirect()
                ->route('peminjam.dashboard')
                ->with('success', 'Ajuan peminjaman berhasil disubmit!  Menunggu approval dari Bapendik.');
        }

        // Lanjut ke hari berikutnya
        return redirect()
            ->route('peminjam.ajuan.step2', $peminjaman_id)
            ->with('success', 'Detail hari ' . $validated['hari'] . ' berhasil disimpan.');
    }
}