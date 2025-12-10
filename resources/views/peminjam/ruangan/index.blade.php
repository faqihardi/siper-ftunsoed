<x-dashboard-layout>
    <x-slot name="title">Daftar Ruangan - SIPER FT Unsoed</x-slot>
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

    <h1>Daftar Gedung & Ruangan</h1>

    <div class="search-bar" style="margin:  30px 0;">
        <input type="text" id="search-gedung" placeholder="Cari gedung atau ruangan..." style="width: 100%; max-width: 400px; padding: 10px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        @forelse($gedungs ?? [] as $gedung)
            <div style="background:  white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); transition: transform 0.3s ease;" onmouseover="this.style. transform='translateY(-5px)'" onmouseout="this. style.transform='translateY(0)'">
                <h3 style="margin: 0 0 15px 0; color: #1e1e2d; font-size: 20px;">
                    <i class="fas fa-building" style="color: #3498db; margin-right: 10px;"></i>
                    {{ $gedung->nama_gedung }}
                </h3>
                <p style="color: #666; margin: 0 0 15px 0;">{{ $gedung->ruangan->count() }} ruangan tersedia</p>
                <a href="{{ route('peminjam.ruangan.showGedung', $gedung->gedung_id) }}" style="display: inline-block; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 8px; font-size: 14px; transition: background-color 0.3s;" onmouseover="this.style. backgroundColor='#2980b9'" onmouseout="this.style.backgroundColor='#3498db'">
                    Lihat Ruangan
                </a>
            </div>
        @empty
            <p style="grid-column: 1 / -1; text-align: center; color: #666; padding: 40px;">Belum ada data gedung</p>
        @endforelse
    </div>

    <x-slot name="scripts">
        <script>
            document.getElementById('search-gedung')?.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const cards = document.querySelectorAll('[onmouseover]');
                
                cards.forEach(card => {
                    const text = card. textContent.toLowerCase();
                    card.parentElement.style.display = text. includes(searchTerm) ? '' : 'none';
                });
            });
        </script>
    </x-slot>
</x-dashboard-layout>