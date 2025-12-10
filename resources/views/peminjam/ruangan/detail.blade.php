<x-dashboard-layout>
    <x-slot name="title">Detail Ruangan - SIPER FT Unsoed</x-slot>
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
            <li><a href="{{ route('peminjam.ruangan.index') }}" class="nav-item active">
                <i class="fas fa-building"></i>
                <span>Daftar Ruangan</span>
            </a></li>
            <li><a href="{{ route('peminjam.notifikasi.index') }}" class="nav-item">
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
            </a></li>
        </ul>
    </x-slot>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('peminjam.ruangan.index') }}" style="display: inline-flex; align-items: center; color: #666; text-decoration: none; font-size: 14px; transition: color 0.3s;" onmouseover="this.style. color='#1e1e2d'" onmouseout="this. style.color='#666'">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>
            Kembali ke Daftar Ruangan
        </a>
    </div>

    <div style="background-color: #fff; border-radius: 15px; padding: 40px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap:  40px;">
            <!-- Left Column:  Room Info -->
            <div>
                <h1 style="font-size: 28px; font-weight: 700; color: #1e1e2d; margin-bottom: 10px;">
                    {{ $ruangan->nama_ruang }}
                </h1>
                <p style="color: #666; font-size:  16px; margin-bottom:  30px;">
                    <i class="fas fa-building" style="color: #3498db; margin-right: 8px;"></i>
                    {{ $ruangan->gedung->nama_gedung ??  '-' }}
                </p>

                <div style="margin-bottom: 25px;">
                    <h3 style="font-size: 18px; font-weight: 600; color:  #1e1e2d; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">
                        Informasi Ruangan
                    </h3>
                    
                    <div style="display:  flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f8f9fa;">
                        <span style="color: #666; font-weight: 500;">Kapasitas</span>
                        <span style="color: #1e1e2d; font-weight: 600;">{{ $ruangan->kapasitas }} orang</span>
                    </div>

                    <div style="display:  flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f8f9fa;">
                        <span style="color:  #666; font-weight: 500;">Tipe Ruangan</span>
                        <span style="color: #1e1e2d; font-weight: 600; text-transform: capitalize;">{{ $ruangan->tipe_ruang }}</span>
                    </div>

                    <div style="display: flex; justify-content:  space-between; padding: 12px 0; border-bottom:  1px solid #f8f9fa;">
                        <span style="color: #666; font-weight: 500;">Gedung</span>
                        <span style="color: #1e1e2d; font-weight: 600;">{{ $ruangan->gedung->nama_gedung ??  '-' }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding:  12px 0;">
                        <span style="color: #666; font-weight:  500;">Status</span>
                        <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500; background-color: #d4edda; color: #155724;">Tersedia</span>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <a href="{{ route('peminjam.ajuan.create', ['ruang_id' => $ruangan->ruang_id]) }}" style="display: inline-block; padding: 14px 30px; background-color: #3498db; color: white; text-decoration: none; border-radius: 10px; font-size: 16px; font-weight: 500; transition: background-color 0.3s; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);" onmouseover="this.style.backgroundColor='#2980b9'" onmouseout="this.style. backgroundColor='#3498db'">
                        <i class="fas fa-calendar-plus" style="margin-right: 10px;"></i>
                        Ajukan Peminjaman
                    </a>
                </div>
            </div>

            <!-- Right Column: Schedule -->
            <div>
                <h3 style="font-size: 18px; font-weight: 600; color: #1e1e2d; margin-bottom:  15px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">
                    Jadwal Peminjaman
                </h3>

                @if($jadwals->count() > 0)
                    <div style="max-height: 400px; overflow-y: auto;">
                        @foreach($jadwals as $jadwal)
                            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 10px; border-left: 4px solid {{ $jadwal->status == 'disetujui subkoor' ? '#28a745' : '#ffc107' }};">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                    <div style="flex:  1;">
                                        <p style="margin:  0; font-weight: 600; color: #1e1e2d; font-size: 14px;">{{ $jadwal->user->nama_user }}</p>
                                        <p style="margin: 5px 0 0 0; color: #666; font-size: 12px;">{{ $jadwal->tujuan }}</p>
                                    </div>
                                    <span style="display: inline-block; padding: 3px 10px; border-radius: 10px; font-size: 11px; font-weight: 500; background-color: {{ $jadwal->status == 'disetujui subkoor' ? '#d4edda' : '#fff3cd' }}; color: {{ $jadwal->status == 'disetujui subkoor' ? '#155724' : '#856404' }};">
                                        {{ ucfirst(str_replace('_', ' ', $jadwal->status)) }}
                                    </span>
                                </div>
                                <div style="display: flex; gap: 15px; font-size: 12px; color: #666;">
                                    <span>
                                        <i class="fas fa-calendar" style="margin-right: 5px; color: #3498db;"></i>
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal_peminjaman)->format('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-clock" style="margin-right: 5px; color: #3498db;"></i>
                                        {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 40px 20px; color: #999;">
                        <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 15px; color: #ddd;"></i>
                        <p style="margin:  0; font-size: 14px;">Belum ada jadwal peminjaman</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>