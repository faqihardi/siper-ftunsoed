<x-dashboard-layout>
    <x-slot name="title">{{ $gedung->nama_gedung }} - SIPER FT Unsoed</x-slot>
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
        <a href="{{ route('peminjam.ruangan.index') }}" style="display: inline-flex; align-items: center; color: #666; text-decoration:  none; font-size: 14px; transition: color 0.3s;" onmouseover="this.style.color='#1e1e2d'" onmouseout="this.style.color='#666'">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>
            Kembali ke Daftar Gedung
        </a>
    </div>

    <h1 style="font-size: 28px; font-weight: 700; color: #1e1e2d; margin-bottom:  10px;">
        <i class="fas fa-building" style="color: #3498db; margin-right: 10px;"></i>
        {{ $gedung->nama_gedung }}
    </h1>
    <p style="color: #666; margin-bottom: 30px;">{{ $gedung->ruangan->count() }} ruangan tersedia</p>

    <div class="search-bar" style="margin-bottom: 30px;">
        <input type="text" id="search-ruangan" placeholder="Cari ruangan..." style="width: 100%; max-width: 400px; padding: 10px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        @forelse($gedung->ruangan as $ruangan)
            <div class="ruangan-card" style="background:  white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this. style.transform='translateY(0)'">
                <h3 style="margin:  0 0 15px 0; color: #1e1e2d; font-size: 20px; font-weight: 600;">
                    {{ $ruangan->nama_ruang }}
                </h3>
                <div style="margin-bottom: 15px;">
                    <p style="margin: 0 0 8px 0; color: #666; font-size: 14px;">
                        <i class="fas fa-users" style="color: #3498db; margin-right: 8px; width: 20px;"></i>
                        Kapasitas: {{ $ruangan->kapasitas }} orang
                    </p>
                    <p style="margin: 0; color: #666; font-size:  14px; text-transform: capitalize;">
                        <i class="fas fa-door-open" style="color: #3498db; margin-right:  8px; width: 20px;"></i>
                        Tipe: {{ $ruangan->tipe_ruang }}
                    </p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('peminjam.ruangan.detail', $ruangan->ruang_id) }}" style="flex: 1; display: inline-block; padding: 10px 15px; background-color:  #3498db; color: white; text-decoration: none; border-radius: 8px; font-size: 14px; text-align: center; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#2980b9'" onmouseout="this.style.backgroundColor='#3498db'">
                        Lihat Detail
                    </a>
                    <a href="{{ route('peminjam.ajuan.create', ['ruang_id' => $ruangan->ruang_id]) }}" style="flex: 1; display: inline-block; padding:  10px 15px; background-color: #27ae60; color: white; text-decoration: none; border-radius: 8px; font-size: 14px; text-align: center; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#229954'" onmouseout="this.style.backgroundColor='#27ae60'">
                        Ajukan
                    </a>
                </div>
            </div>
        @empty
            <p style="grid-column: 1 / -1; text-align: center; color: #666; padding: 40px;">Tidak ada ruangan di gedung ini</p>
        @endforelse
    </div>

    <x-slot name="scripts">
        <script>
            document.getElementById('search-ruangan')?.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const cards = document.querySelectorAll('. ruangan-card');
                
                cards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.parentElement.style.display = text. includes(searchTerm) ? '' : 'none';
                });
            });
        </script>
    </x-slot>
</x-dashboard-layout>