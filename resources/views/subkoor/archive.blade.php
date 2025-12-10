<x-dashboard-layout>
    <x-slot name="title">SIPER - Arsip Peminjaman</x-slot>
    <x-slot name="profileLabel">Subkoor</x-slot>
    
    <x-slot name="navigation">
        <li class="nav-item" onclick="window.location.href='{{ route('subkoor.dashboard') }}'">
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
        <h2 class="panel-title">Arsip Peminjaman</h2>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Cari arsip... ">
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
                    nama: 'Andi Wijaya',
                    email: 'andi@example.com',
                    no_hp: '081234567890',
                    ruangan: 'C101',
                    keperluan: 'Workshop',
                    judul_kegiatan: 'Workshop Web Development',
                    tanggal_mulai: '05 November 2025',
                    tanggal_selesai: '06 November 2025',
                    jam_mulai: '08:00',
                    jam_selesai: '12:00',
                    status:  'disetujui bapendik',
                    created_at: '2025-12-10'
                },
                {
                    id: 2,
                    nama: 'Budi Santoso',
                    email: 'budi@example. com',
                    no_hp: '082345678901',
                    ruangan: 'C102',
                    keperluan: 'Rapat',
                    judul_kegiatan: 'Rapat Koordinasi Tim',
                    tanggal_mulai: '08 November 2025',
                    tanggal_selesai: '08 November 2025',
                    jam_mulai: '09:00',
                    jam_selesai: '11:00',
                    status:  'disetujui bapendik',
                    created_at: '2025-12-09'
                },
                {
                    id: 3,
                    nama: 'Siti Rahma',
                    email: 'siti@example.com',
                    no_hp: '083456789012',
                    ruangan: 'Aula',
                    keperluan: 'Seminar',
                    judul_kegiatan: 'Seminar Teknologi',
                    tanggal_mulai: '01 November 2025',
                    tanggal_selesai: '01 November 2025',
                    jam_mulai: '13:00',
                    jam_selesai: '17:00',
                    status:  'disetujui subkoor',
                    created_at: '2025-11-25'
                },
                {
                    id: 4,
                    nama: 'Dedi Kurniawan',
                    email: 'dedi@example.com',
                    no_hp: '084567890123',
                    ruangan: 'Lab Komputer 1',
                    keperluan: 'Praktikum',
                    judul_kegiatan: 'Praktikum Pemrograman',
                    tanggal_mulai: '28 Oktober 2025',
                    tanggal_selesai: '28 Oktober 2025',
                    jam_mulai: '08:00',
                    jam_selesai: '10:00',
                    status:  'disetujui subkoor',
                    created_at: '2025-10-20'
                },
                {
                    id: 5,
                    nama: 'Eko Prasetyo',
                    email:  'eko@example.com',
                    no_hp:  '085678901234',
                    ruangan: 'C103',
                    keperluan: 'Presentasi',
                    judul_kegiatan: 'Presentasi Proyek Akhir',
                    tanggal_mulai: '15 Oktober 2025',
                    tanggal_selesai: '15 Oktober 2025',
                    jam_mulai: '14:00',
                    jam_selesai: '16:00',
                    status: 'ditolak bapendik',
                    created_at: '2025-10-10'
                },
                {
                    id: 6,
                    nama: 'Fitri Handayani',
                    email:  'fitri@example.com',
                    no_hp:  '086789012345',
                    ruangan: 'Ruang Meeting',
                    keperluan: 'Workshop',
                    judul_kegiatan: 'Workshop Design Thinking',
                    tanggal_mulai: '10 Oktober 2025',
                    tanggal_selesai: '11 Oktober 2025',
                    jam_mulai: '09:00',
                    jam_selesai: '15:00',
                    status:  'disetujui bapendik',
                    created_at: '2025-10-01'
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
                                     item. status === 'disetujui bapendik' ? 'Disetujui Bapendik' : 
                                     item.status === 'disetujui subkoor' ?  'Disetujui Subkoor' : 
                                     'Ditolak';

                    const row = document. createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${item.tanggal_mulai}</td>
                        <td>${item.ruangan}</td>
                        <td>${item.jam_mulai} - ${item. jam_selesai}</td>
                        <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    `;
                    tbody.appendChild(row);
                });
            }

            function setupSearch() {
                document.getElementById('search-input').addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document. querySelectorAll('#archive-tbody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
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