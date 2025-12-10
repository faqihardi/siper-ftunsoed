<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeminjamanDetail;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Step 1: Form ajuan utama
    public function create()
    {
        $ruangans = Ruangan::all();
        return view('peminjam.peminjaman.step1', compact('ruangans'));
    }

    // Step 1: Simpan data dasar
    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'ruang_id'            => 'required|exists:ruangans,ruang_id',
            'tanggal_peminjaman'  => 'required|date',
            'tanggal_selesai'     => 'required|date|after_or_equal:tanggal_peminjaman',
            'jam_mulai'           => 'required|date_format:H:i',
            'jam_selesai'         => 'required|date_format:H:i|after:jam_mulai',
            'tujuan'              => 'required|string|max:255',
            'detail_kegiatan'     => 'nullable|string',
        ]);

        // Cek Bentrokan
        if ($this->isConflict(
            $validated['ruang_id'],
            $validated['tanggal_peminjaman'],
            $validated['tanggal_selesai'],
            $validated['jam_mulai'],
            $validated['jam_selesai']
        )) {
            return back()->withErrors([
                'ruang_id' => 'Ruangan sudah dipakai pada waktu tersebut.'
            ]);
        }

        $peminjaman = Peminjaman::create([
            'user_id'             => Auth::id(),
            'ruang_id'            => $validated['ruang_id'],
            'tanggal_peminjaman'  => $validated['tanggal_peminjaman'],
            'tanggal_selesai'     => $validated['tanggal_selesai'],
            'jam_mulai'           => $validated['jam_mulai'],
            'jam_selesai'         => $validated['jam_selesai'],
            'tujuan'              => $validated['tujuan'],
            'detail_kegiatan'     => $validated['detail_kegiatan'],
            'durasi'              => now()->parse($validated['tanggal_peminjaman'])
                                      ->diffInDays($validated['tanggal_selesai']) + 1,
            'status'              => 'draft'
        ]);

        return redirect()
            ->route('peminjaman.step2', $peminjaman->peminjaman_id)
            ->with('success', 'Langkah pertama berhasil disimpan.');
    }

    // Step 2: Halaman mengisi detail sesuai durasi
    public function createStep2($peminjaman_id)
    {
        $peminjaman = Peminjaman::findOrFail($peminjaman_id);
        return view('peminjam.peminjaman.step2', compact('peminjaman'));
    }

    // Step 2: Simpan detail harian
    public function storeStep2(Request $request, $peminjaman_id)
    {

        $peminjaman = Peminjaman::findOrFail($peminjaman_id);

        $validated = $request->validate([
            'tanggal.*'      => 'required|date',
            'jam_mulai.*'    => 'required|date_format:H:i',
            'jam_selesai.*'  => 'required|date_format:H:i|after:jam_mulai.*',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,png|max:4096',
        ]);

        // UPLOAD DOKUMEN
        if ($request->hasFile('dokumen_pendukung')) {
            $peminjaman->dokumen_pendukung =
                $request->file('dokumen_pendukung')->store('dokumen_peminjaman');
            $peminjaman->save();
        }

        // CEK BENTROK PER HARI
        foreach ($validated['tanggal'] as $i => $tgl) {
            if ($this->isConflict(
                $peminjaman->ruang_id,
                $tgl,
                $tgl,
                $validated['jam_mulai'][$i],
                $validated['jam_selesai'][$i]
            )) {
                return back()->withErrors([
                    'tanggal' => "Ruangan bentrok pada tanggal $tgl"
                ]);
            }
        }

        // SIMPAN DETAIL
        foreach ($validated['tanggal'] as $i => $tgl) {
            PeminjamanDetail::create([
                'peminjaman_id' => $peminjaman->peminjaman_id,
                'tanggal'       => $tgl,
                'jam_mulai'     => $validated['jam_mulai'][$i],
                'jam_selesai'   => $validated['jam_selesai'][$i],
            ]);
        }

        // UPDATE STATUS MENJADI DIAJUKAN
        $peminjaman->update([
            'status' => 'diajukan'
        ]);

        return redirect()
            ->route('peminjam.dashboard')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    private function isConflict($ruang_id, $tglMulai, $tglSelesai, $jamMulai, $jamSelesai)
    {
        return Peminjaman::where('ruang_id', $ruang_id)
            ->where('status', 'approved')

            // Cek tanggal overlap
            ->where(function ($q) use ($tglMulai, $tglSelesai) {
                $q->whereBetween('tanggal_peminjaman', [$tglMulai, $tglSelesai])
                  ->orWhereBetween('tanggal_selesai', [$tglMulai, $tglSelesai])
                  ->orWhere(function ($qq) use ($tglMulai, $tglSelesai) {
                      $qq->where('tanggal_peminjaman', '<=', $tglMulai)
                         ->where('tanggal_selesai', '>=', $tglSelesai);
                  });
            })

            // Cek jam overlap
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                  ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                  ->orWhere(function ($qq) use ($jamMulai, $jamSelesai) {
                      $qq->where('jam_mulai', '<=', $jamMulai)
                         ->where('jam_selesai', '>=', $jamSelesai);
                  });
            })

            ->exists();
    }
    
}
