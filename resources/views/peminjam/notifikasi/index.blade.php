<x-dashboard-layout>
    <x-slot name="title">Notifikasi - SIPER FT Unsoed</x-slot>
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
            <li><a href="{{ route('peminjam.notifikasi.index') }}" class="nav-item active">
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
            </a></li>
        </ul>
    </x-slot>

    <h1>Notifikasi</h1>

    <div style="background-color: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-top: 30px;">
        @forelse($notifikasis ?? [] as $notif)
            <div style="padding: 15px; border-bottom: 1px solid #f0f0f0; {{ $notif->status_baca == 'unread' ? 'background-color: #f8f9fa;' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div style="flex: 1;">
                        <p style="margin: 0 0 5px 0; font-weight: 600; color: #1e1e2d;">{{ $notif->pesan }}</p>
                        <small style="color: #666;">{{ \Carbon\Carbon::parse($notif->waktu_kirim)->diffForHumans() }}</small>
                    </div>
                    @if($notif->status_baca == 'unread')
                        <span style="display: inline-block; width: 10px; height: 10px; background-color: #3498db; border-radius: 50%;"></span>
                    @endif
                </div>
            </div>
        @empty
            <p style="text-align: center; color: #666; padding: 40px;">Tidak ada notifikasi</p>
        @endforelse
    </div>
</x-dashboard-layout>