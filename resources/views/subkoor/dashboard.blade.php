<x-dashboard-layout>
    <x-slot name="title">SIPER - Dashboard Subkoor</x-slot>
    <x-slot name="profileLabel">Subkoor</x-slot>
    
    <x-slot name="navigation">
        <li class="nav-item active" data-page="dashboard">
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
        </li>
        <li class="nav-item" data-page="arsip">
            <i class="fas fa-archive"></i>
            <span>Arsip Peminjaman</span>
        </li>
        <li class="nav-item" data-page="notifikasi">
            <i class="fas fa-bell"></i>
            <span>Notifikasi</span>
        </li>
    </x-slot>

    <!-- Dashboard Page -->
    <div class="page active" id="dashboard-page">
        <div class="content-wrapper">
            <!-- Left Panel:  Table -->
            <div class="left-panel">
                <h2 class="panel-title">Daftar Ajuan Peminjaman</h2>
                <div class="search-bar">
                    <input type="text" id="search-input" placeholder="Cari peminjaman...">
                </div>
                <table class="peminjaman-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Ruangan</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="peminjaman-tbody">
                        <!-- Data will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Right Panel: Detail -->
            <div class="right-panel" id="detail-panel">
                <h2 class="panel-title">Identitas Peminjam</h2>
                <div id="detail-content">
                    <!-- Detail will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Arsip Page -->
    <div class="page" id="arsip-page">
        <div class="arsip-container">
            <h2 class="panel-title">Arsip Peminjaman</h2>
            <div class="search-bar">
                <input type="text" id="arsip-search-input" placeholder="Cari arsip...">
            </div>
            <table class="peminjaman-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Ruangan</th>
                        <th>Keperluan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="arsip-tbody">
                    <!-- Arsip data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Notifikasi Page -->
    <div class="page" id="notifikasi-page">
        <div class="arsip-container">
            <h2 class="panel-title">Notifikasi</h2>
            <p style="color: #666; text-align: center; padding: 40px;">Tidak ada notifikasi baru</p>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            let peminjamanData = [
                {
                    peminjaman_id: 1,
                    user_id: 1,
                    nama: 'Andi Wijaya',
                    email: 'andi@example.com',
                    no_hp: '081234567890',
                    ruang_id: 5,
                    ruangan: 'C101',
                    keperluan: 'Workshop',
                    judul_kegiatan: 'Workshop Web Development',
                    dokumen_pendukung: 'proposal. pdf',
                    tanggal_mulai: '05 November 2025',
                    tanggal_selesai: '06 November 2025',
                    durasi: 2,
                    status: 'disetujui bapendik',
                    notes: null,
                    created_at:  '2025-12-10',
                    detail_days: [
                        {
                            detail_id: 1,
                            hari: 1,
                            tanggal_peminjaman: '05 November 2025',
                            jam_mulai: '08:00',
                            jam_selesai: '12:00'
                        },
                        {
                            detail_id: 2,
                            hari:  2,
                            tanggal_peminjaman: '06 November 2025',
                            jam_mulai: '13:00',
                            jam_selesai: '17:00'
                        }
                    ]
                },
                {
                    peminjaman_id:  2,
                    user_id: 2,
                    nama: 'Budi Santoso',
                    email:  'budi@example.com',
                    no_hp:  '082345678901',
                    ruang_id: 1,
                    ruangan: 'C102',
                    keperluan: 'Rapat',
                    judul_kegiatan: 'Rapat Koordinasi Tim',
                    dokumen_pendukung: 'surat. pdf',
                    tanggal_mulai: '08 November 2025',
                    tanggal_selesai: '08 November 2025',
                    durasi: 1,
                    status: 'disetujui bapendik',
                    notes: null,
                    created_at: '2025-12-09',
                    detail_days: [
                        {
                            detail_id: 3,
                            hari: 1,
                            tanggal_peminjaman: '08 November 2025',
                            jam_mulai: '09:00',
                            jam_selesai: '11:00'
                        }
                    ]
                }
            ];

            let arsipData = [
                {
                    arsip_id: 1,
                    nama: 'Siti Rahma',
                    email: 'siti@example.com',
                    ruangan: 'Aula',
                    keperluan: 'Seminar',
                    tanggal:  '01 November 2025',
                    status: 'disetujui subkoor'
                },
                {
                    arsip_id: 2,
                    nama: 'Dedi Kurniawan',
                    email: 'dedi@example.com',
                    ruangan: 'Lab Komputer 1',
                    keperluan: 'Praktikum',
                    tanggal: '28 Oktober 2025',
                    status: 'disetujui subkoor'
                }
            ];

            let selectedPeminjaman = null;

            function init() {
                loadPeminjamanTable();
                loadArsipTable();
                setupEventListeners();
            }

            function loadPeminjamanTable() {
                const tbody = document. getElementById('peminjaman-tbody');
                tbody.innerHTML = '';

                peminjamanData.forEach((item, index) => {
                    const statusClass = item. status === 'pending' ? 'status-pending' : 
                                      item.status === 'disetujui bapendik' ? 'status-pending' : 
                                      item.status === 'disetujui subkoor' ? 'status-approved' : 
                                      'status-rejected';
                    
                    const statusText = item. status === 'pending' ? 'Menunggu' : 
                                     item.status === 'disetujui bapendik' ? 'Menunggu Subkoor' :  
                                     item.status === 'disetujui subkoor' ? 'Disetujui' : 
                                     'Ditolak';

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${item.tanggal_mulai}</td>
                        <td>${item.ruangan}</td>
                        <td>${item. detail_days[0].jam_mulai} - ${item. detail_days[0].jam_selesai}</td>
                        <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                        <td><button class="btn-detail" onclick="showDetail(${item.peminjaman_id})">Detail</button></td>
                    `;
                    tbody.appendChild(row);
                });
            }

            function loadArsipTable() {
                const tbody = document.getElementById('arsip-tbody');
                tbody.innerHTML = '';

                arsipData.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${item.nama}</td>
                        <td>${item. email}</td>
                        <td>${item.ruangan}</td>
                        <td>${item.keperluan}</td>
                        <td>${item.tanggal}</td>
                        <td><span class="status-badge status-approved">${item.status}</span></td>
                    `;
                    tbody.appendChild(row);
                });
            }

            function showDetail(peminjamanId) {
                const peminjaman = peminjamanData.find(p => p.peminjaman_id === peminjamanId);
                if (! peminjaman) return;

                selectedPeminjaman = peminjaman;

                const detailContent = document.getElementById('detail-content');
                detailContent.innerHTML = `
                    <div class="detail-section">
                        <h3>Identitas Peminjam</h3>
                        <div class="detail-row">
                            <span class="detail-label">Nama: </span>
                            <span class="detail-value">${peminjaman.nama}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">${peminjaman.email}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">No HP:</span>
                            <span class="detail-value">${peminjaman.no_hp}</span>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3>Detail Peminjaman</h3>
                        <div class="detail-row">
                            <span class="detail-label">Ruang:</span>
                            <span class="detail-value">${peminjaman.ruangan}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Keperluan:</span>
                            <span class="detail-value">${peminjaman.keperluan}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Judul Kegiatan: </span>
                            <span class="detail-value">${peminjaman.judul_kegiatan}</span>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3>Dokumen Pendukung</h3>
                        <div class="dokumen-section">
                            <a href="#" class="dokumen-link" onclick="downloadDokumen('${peminjaman.dokumen_pendukung}')">
                                <i class="fas fa-file-pdf"></i> ${peminjaman.dokumen_pendukung}
                            </a>
                        </div>
                    </div>

                    ${peminjaman.status === 'disetujui bapendik' ? `
                        <div class="action-buttons">
                            <button class="btn-approve" onclick="approvePeminjaman(${peminjaman.peminjaman_id})">Setuju</button>
                            <button class="btn-reject" onclick="rejectPeminjaman(${peminjaman.peminjaman_id})">Tolak</button>
                        </div>
                    ` : ''}
                `;

                document.getElementById('detail-panel').classList.add('active');
            }

            function approvePeminjaman(peminjamanId) {
                if (! confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')) return;

                const peminjaman = peminjamanData.find(p => p.peminjaman_id === peminjamanId);
                if (peminjaman) {
                    peminjaman. status = 'disetujui subkoor';
                    loadPeminjamanTable();
                    document.getElementById('detail-panel').classList.remove('active');
                    alert('Peminjaman telah disetujui! ');
                }
            }

            function rejectPeminjaman(peminjamanId) {
                if (!confirm('Apakah Anda yakin ingin menolak peminjaman ini?')) return;

                const peminjaman = peminjamanData.find(p => p.peminjaman_id === peminjamanId);
                if (peminjaman) {
                    peminjaman.status = 'ditolak subkoor';
                    loadPeminjamanTable();
                    document.getElementById('detail-panel').classList.remove('active');
                    alert('Peminjaman telah ditolak!');
                }
            }

            function downloadDokumen(filename) {
                alert(`Mengunduh: ${filename}`);
            }

            function setupEventListeners() {
                document.querySelectorAll('.nav-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const page = this.getAttribute('data-page');
                        
                        document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
                        this.classList. add('active');
                        
                        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
                        document.getElementById(`${page}-page`).classList.add('active');
                        
                        document.getElementById('detail-panel').classList.remove('active');
                    });
                });

                document.getElementById('search-input').addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document. querySelectorAll('#peminjaman-tbody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });

                document. getElementById('arsip-search-input').addEventListener('input', function(e) {
                    const searchTerm = e.target.value. toLowerCase();
                    const rows = document.querySelectorAll('#arsip-tbody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            init();
        </script>
    </x-slot>
</x-dashboard-layout>