<x-dashboard-layout>
    <x-slot name="title">Detail Peminjaman - SIPER FT Unsoed</x-slot>
    <x-slot name="profileLabel">{{ Auth::user()->nama_user }}</x-slot>
    
    <x-slot name="navigation">
        <ul>
            <li><a href="{{ route('peminjam.dashboard') }}" class="nav-item">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a></li>
            <li><a href="{{ route('peminjam.ajuan.create') }}" class="nav-item">
                <i class="fas fa-plus-circle"></i>
                <span>Ajukan Peminjaman</span>
            </a></li>
            <li><a href="{{ route('peminjam.ruangan.index') }}" class="nav-item">
                <i class="fas fa-building"></i>
                <span>Daftar Ruangan</span>
            </a></li>
            <li><a href="{{ route('peminjam.notifikasi.index') }}" class="nav-item">
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
            </a></li>
        </ul>
    </x-slot>

    <style>
        .detail-card {
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .detail-card h2 {
            color: #1e1e2d;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
        }

        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .info-label {
            width: 200px;
            color: #666;
            font-weight: 500;
        }

        .info-value {
            flex: 1;
            color: #2c3e50;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .detail-table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .detail-table thead th {
            padding: 12px 15px;
            text-align: left;
            background-color: #34495e;
            color: white;
            font-weight: 500;
        }

        .detail-table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #ecf0f1;
        }

        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #95a5a6;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #7f8c8d;
        }
    </style>

    <div class="detail-card">
        <h2>Detail Peminjaman Ruangan</h2>

        <div class="info-row">
            <div class="info-label">Ruangan</div>
            <div class="info-value">{{ $peminjaman->ruangan->nama_ruang }} - {{ $peminjaman->ruangan->gedung->nama_gedung }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Tujuan</div>
            <div class="info-value">{{ $peminjaman->tujuan }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Detail Kegiatan</div>
            <div class="info-value">{{ $peminjaman->detail_kegiatan }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Periode Peminjaman</div>
            <div class="info-value">
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d M Y') }} 
                @if($peminjaman->tanggal_selesai && $peminjaman->tanggal_selesai != $peminjaman->tanggal_peminjaman)
                    - {{ \Carbon\Carbon::parse($peminjaman->tanggal_selesai)->format('d M Y') }}
                @endif
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">Waktu</div>
            <div class="info-value">{{ $peminjaman->jam_mulai }} - {{ $peminjaman->jam_selesai }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Durasi</div>
            <div class="info-value">{{ $peminjaman->durasi }} hari</div>
        </div>

        <div class="info-row">
            <div class="info-label">Status</div>
            <div class="info-value">
                @if($peminjaman->status == 'draft')
                    <span class="status-badge" style="background-color: #e2e3e5; color: #383d41;">Draft</span>
                @elseif($peminjaman->status == 'pending')
                    <span class="status-badge" style="background-color: #fff3cd; color: #856404;">Menunggu Approval</span>
                @elseif($peminjaman->status == 'disetujui bapendik')
                    <span class="status-badge" style="background-color: #cce5ff; color: #004085;">Disetujui Bapendik</span>
                @elseif($peminjaman->status == 'disetujui subkoor')
                    <span class="status-badge" style="background-color: #d4edda; color: #155724;">Disetujui</span>
                @elseif(str_contains($peminjaman->status, 'ditolak'))
                    <span class="status-badge" style="background-color: #f8d7da; color: #721c24;">Ditolak</span>
                @else
                    <span class="status-badge" style="background-color: #e2e3e5; color: #383d41;">{{ ucfirst($peminjaman->status) }}</span>
                @endif
            </div>
        </div>

        @if($peminjaman->dokumen_pendukung)
        <div class="info-row">
            <div class="info-label">Dokumen Pendukung</div>
            <div class="info-value">
                <a href="{{ Storage::url($peminjaman->dokumen_pendukung) }}" target="_blank" style="color: #3498db; text-decoration: none;">
                    <i class="fas fa-file"></i> Lihat Dokumen
                </a>
            </div>
        </div>
        @endif

        @if($peminjaman->notes)
        <div class="info-row">
            <div class="info-label">Catatan</div>
            <div class="info-value">{{ $peminjaman->notes }}</div>
        </div>
        @endif
    </div>

    @if($peminjaman->details->count() > 0)
    <div class="detail-card">
        <h2>Jadwal Detail Per Hari</h2>

        <table class="detail-table">
            <thead>
                <tr>
                    <th>Hari Ke-</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjaman->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($detail->tanggal)->format('d M Y') }}</td>
                    <td>{{ $detail->jam_mulai }}</td>
                    <td>{{ $detail->jam_selesai }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div style="margin-top: 20px;">
        <a href="{{ route('peminjam.dashboard') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</x-dashboard-layout>
