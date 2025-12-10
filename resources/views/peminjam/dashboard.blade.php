<x-dashboard-layout>
    <x-slot name="title">Dashboard Peminjam - SIPER FT Unsoed</x-slot>
    <x-slot name="profileLabel">{{ Auth::user()->nama_user }}</x-slot>
    
    <x-slot name="navigation">
        <ul>
            <li><a href="{{ route('peminjam.dashboard') }}" class="nav-item active">
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

    <h1>SIPER - Dashboard Peminjam</h1>

    @if(session('success'))
        <div class="alert alert-success" style="padding: 15px; background-color: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="search-bar" style="margin-bottom: 30px;">
        <input type="text" id="search-ruangan" placeholder="Cari ruangan..." style="width: 100%; max-width: 400px; padding: 10px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
    </div>

    <p class="section-title" style="font-size: 18px; font-weight: 600; margin-bottom: 15px; color: #2c3e50;">Daftar Ruangan Fakultas Teknik</p>
    <table class="peminjaman-table" style="width: 100%; background:  white; border-collapse: collapse; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <thead>
            <tr>
                <th style="padding: 12px 15px; text-align: left; background-color: #34495e; color: white; font-weight: 500;">No</th>
                <th style="padding: 12px 15px; text-align: left; background-color: #34495e; color: white; font-weight:  500;">Nama Ruangan</th>
                <th style="padding: 12px 15px; text-align:  left; background-color: #34495e; color: white; font-weight: 500;">Gedung</th>
                <th style="padding: 12px 15px; text-align: left; background-color: #34495e; color: white; font-weight: 500;">Kapasitas</th>
                <th style="padding: 12px 15px; text-align:  left; background-color: #34495e; color: white; font-weight: 500;">Status</th>
                <th style="padding: 12px 15px; text-align: left; background-color: #34495e; color: white; font-weight:  500;">Aksi</th>
            </tr>
        </thead>
        <tbody id="ruangan-tbody">
            @forelse($ruangans ??  [] as $index => $ruangan)
                <tr style="border-bottom: 1px solid #ecf0f1;">
                    <td style="padding: 12px 15px;">{{ $index + 1 }}</td>
                    <td style="padding: 12px 15px;">{{ $ruangan->nama_ruang }}</td>
                    <td style="padding: 12px 15px;">{{ $ruangan->gedung->nama_gedung ??  '-' }}</td>
                    <td style="padding: 12px 15px;">{{ $ruangan->kapasitas }} orang</td>
                    <td style="padding: 12px 15px;">
                        <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500; background-color: #d4edda; color: #155724;">Tersedia</span>
                    </td>
                    <td style="padding: 12px 15px;">
                        <a href="{{ route('peminjam.ruangan.detail', $ruangan->ruang_id) }}" style="color: #3498db; text-decoration: none;">Lihat Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding: 20px; text-align: center; color: #666;">Belum ada data ruangan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="section-title" style="font-size: 18px; font-weight: 600; margin-bottom: 15px; color:  #2c3e50;">Daftar Ajuan Anda</p>
    <table class="peminjaman-table" style="width: 100%; background: white; border-collapse: collapse; border-radius: 8px; overflow:  hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <thead>
            <tr>
                <th style="padding: 12px 15px; text-align: left; background-color: #34495e; color: white; font-weight: 500;">No</th>
                <th style="padding:  12px 15px; text-align: left; background-color: #34495e; color:  white; font-weight: 500;">Ruangan</th>
                <th style="padding: 12px 15px; text-align: left; background-color: #34495e; color: white; font-weight: 500;">Tanggal</th>
                <th style="padding: 12px 15px; text-align:  left; background-color: #34495e; color: white; font-weight: 500;">Waktu</th>
                <th style="padding: 12px 15px; text-align: left; background-color: #34495e; color: white; font-weight: 500;">Status</th>
                <th style="padding: 12px 15px; text-align: left; background-color: #34495e; color: white; font-weight: 500;">Aksi</th>
            </tr>
        </thead>
        <tbody id="ajuan-tbody">
            @forelse($peminjamans ?? [] as $index => $peminjaman)
                <tr style="border-bottom: 1px solid #ecf0f1;">
                    <td style="padding: 12px 15px;">{{ $index + 1 }}</td>
                    <td style="padding: 12px 15px;">{{ $peminjaman->ruangan->nama_ruang }}</td>
                    <td style="padding: 12px 15px;">{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d M Y') }}</td>
                    <td style="padding: 12px 15px;">{{ $peminjaman->jam_mulai }} - {{ $peminjaman->jam_selesai }}</td>
                    <td style="padding: 12px 15px;">
                        @if($peminjaman->status == 'pending')
                            <span style="display: inline-block; padding:  4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500; background-color: #fff3cd; color: #856404;">Menunggu Approval</span>
                        @elseif($peminjaman->status == 'disetujui bapendik')
                            <span style="display: inline-block; padding:  4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500; background-color: #cce5ff; color: #004085;">Disetujui Bapendik</span>
                        @elseif($peminjaman->status == 'disetujui subkoor')
                            <span style="display: inline-block; padding:  4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500; background-color: #d4edda; color: #155724;">Disetujui</span>
                        @elseif(str_contains($peminjaman->status, 'ditolak'))
                            <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500; background-color: #f8d7da; color: #721c24;">Ditolak</span>
                        @else
                            <span style="display:  inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500; background-color:  #e2e3e5; color: #383d41;">{{ ucfirst($peminjaman->status) }}</span>
                        @endif
                    </td>
                    <td style="padding: 12px 15px;">
                        <a href="#" style="color: #3498db; text-decoration: none;">Lihat Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding:  20px; text-align:  center; color: #666;">Belum ada ajuan peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <x-slot name="scripts">
        <script>
            // Search functionality
            document.getElementById('search-ruangan')?.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#ruangan-tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        </script>
    </x-slot>
</x-dashboard-layout>