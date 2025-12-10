<x-dashboard-layout>
    <x-slot name="title">SIPER - Arsip Peminjaman</x-slot>
    <x-slot name="profileLabel">Wakil Dekan II</x-slot>
    
    <x-slot name="navigation">
        <li class="nav-item" onclick="window.location.href='{{ route('wd.dashboard') }}'">
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
        </li>
        <li class="nav-item active">
            <i class="fas fa-archive"></i>
            <span>Arsip Peminjaman</span>
        </li>
        <li class="nav-item">
            <i class="fas fa-bell"></i>
            <span>Notifikasi</span>
        </li>
    </x-slot>

    <div class="archive-container">
        <h2 class="panel-title">Arsip Peminjaman Aula Gedung F</h2>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Cari arsip...">
        </div>
        <table class="archive-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Ruangan</th>
                    <th>Waktu</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="archive-tbody">
                <!-- Data will be populated by JavaScript -->
            </tbody>
        </table>
    </div>

    <x-slot name="scripts">
        <script>
            const archiveData = [
                {
                    id: 1,
                    nama: 'Linda Kartika',
                    email: 'linda@example.com',
                    no_hp:  '081122334455',
                    ruangan: 'Aula Gedung F',
                    keperluan: 'Wisuda',
                    judul_kegiatan: 'Wisuda Fakultas Teknik',
                    tanggal_mulai: '01 November 2025',
                    tanggal_selesai:  '01 November 2025',
                    jam_mulai:  '08:00',
                    jam_selesai: '17:00',
                    status:  'disetujui wd2',
                    created_at: '2025-10-25'
                },
                {
                    id: 2,
                    nama: 'Budi Hartono',
                    email: 'budi.h@example. com',
                    no_hp: '082233445566',
                    ruangan: 'Aula Gedung F',
                    keperluan: 'Seminar Nasional',
                    judul_kegiatan: 'Seminar Nasional Teknologi',
                    tanggal_mulai: '15 Oktober 2025',
                    tanggal_selesai:  '15 Oktober 2025',
                    jam_mulai:  '08:00',
                    jam_selesai: '16:00',
                    status:  'disetujui subkoor',
                    created_at: '2025-10-01'
                },
                {
                    id:  3,
                    nama:  'Dewi Anggraeni',
                    email: 'dewi@example.com',
                    no_hp: '083344556677',
                    ruangan: 'Aula Gedung F',
                    keperluan: 'Rapat Besar',
                    judul_kegiatan: 'Rapat Koordinasi Fakultas',
                    tanggal_mulai: '28 September 2025',
                    tanggal_selesai: '28 September 2025',
                    jam_mulai: '09:00',
                    jam_selesai: '12:00',
                    status:  'disetujui subkoor',
                    created_at: '2025-09-20'
                },
                {
                    id: 4,
                    nama: 'Rizki Pratama',
                    email: 'rizki@example.com',
                    no_hp: '084455667788',
                    ruangan: 'Aula Gedung F',
                    keperluan: 'Workshop',
                    judul_kegiatan: 'Workshop Teknologi AI',
                    tanggal_mulai: '10 September 2025',
                    tanggal_selesai: '11 September 2025',
                    jam_mulai: '08:00',
                    jam_selesai: '17:00',
                    status:  'disetujui subkoor',
                    created_at: '2025-08-30'
                },
                {
                    id: 5,
                    nama: 'Andi Saputra',
                    email:  'andi. s@example.com',
                    no_hp: '085566778899',
                    ruangan: 'Aula Gedung F',
                    keperluan: 'Seminar',
                    judul_kegiatan: 'Seminar Kewirausahaan',
                    tanggal_mulai: '25 Agustus 2025',
                    tanggal_selesai: '25 Agustus 2025',
                    jam_mulai: '13:00',
                    jam_selesai: '17:00',
                    status:  'ditolak wd2',
                    created_at: '2025-08-15'
                }
            ];

            function loadArchiveTable() {
                const tbody = document.getElementById('archive-tbody');
                tbody.innerHTML = '';

                archiveData.forEach((item, index) => {
                    const statusClass = item.status === 'pending' ? 'status-pending' : 
                                      item.status. includes('disetujui') ? 'status-approved' :  
                                      'status-rejected';
                    
                    const statusText = item.status === 'pending' ? 'Menunggu' : 
                                     item.status === 'disetujui wd2' ? 'Disetujui WD2' : 
                                     item.status === 'disetujui subkoor' ? 'Disetujui Subkoor' : 
                                     'Ditolak';

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${item.tanggal_mulai}</td>
                        <td>${item.ruangan}</td>
                        <td>${item.jam_mulai} - ${item.jam_selesai}</td>
                        <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    `;
                    tbody.appendChild(row);
                });
            }

            function setupSearch() {
                document.getElementById('search-input').addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('#archive-tbody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style. display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            function init() {
                loadArchiveTable();
                setupSearch();
            }

            init();
        </script>
    </x-slot>
</x-dashboard-layout>