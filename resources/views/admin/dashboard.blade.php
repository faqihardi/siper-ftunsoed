<x-dashboard-layout>
    <x-slot name="title">SIPER - Dashboard Bapendik</x-slot>
    <x-slot name="profileLabel">Bapendik</x-slot>
    
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
                    <input type="text" id="search-input" placeholder="Cari peminjaman... ">
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

            <!-- Right Panel:  Detail -->
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
            // Data dari backend
            let peminjamanData = {!! json_encode($peminjamans->map(function($p) {
                return [
                    'peminjaman_id' => $p->peminjaman_id,
                    'user_id' => $p->user_id,
                    'nama' => $p->user->nama_user,
                    'email' => $p->user->email,
                    'no_hp' => $p->user->no_hp,
                    'ruang_id' => $p->ruang_id,
                    'ruangan' => $p->ruangan->nama_ruang,
                    'gedung' => $p->ruangan->gedung->nama_gedung,
                    'keperluan' => $p->tujuan,
                    'judul_kegiatan' => $p->detail_kegiatan,
                    'dokumen_pendukung' => $p->dokumen_pendukung,
                    'tanggal_mulai' => \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d M Y'),
                    'tanggal_selesai' => $p->tanggal_selesai ? \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') : null,
                    'jam_mulai' => $p->jam_mulai,
                    'jam_selesai' => $p->jam_selesai,
                    'durasi' => $p->durasi,
                    'status' => $p->status,
                    'notes' => $p->notes,
                    'created_at' => $p->created_at->format('Y-m-d'),
                    'detail_days' => $p->details->map(function($d, $index) {
                        return [
                            'detail_id' => $d->peminjaman_details_id,
                            'hari' => $index + 1,
                            'tanggal_peminjaman' => \Carbon\Carbon::parse($d->tanggal)->format('d M Y'),
                            'jam_mulai' => $d->jam_mulai,
                            'jam_selesai' => $d->jam_selesai
                        ];
                    })->toArray()
                ];
            })->toArray()) !!};

            let arsipData = [];

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
                    const statusClass = item.status === 'pending' ? 'status-pending' : 
                                      item.status === 'disetujui bapendik' ? 'status-approved' : 
                                      'status-rejected';
                    
                    const statusText = item.status === 'pending' ? 'Menunggu' : 
                                     item.status === 'disetujui bapendik' ? 'Disetujui' : 
                                     'Ditolak';

                    // Ambil jam dari detail_days jika ada, atau dari peminjaman utama
                    const jamMulai = item.detail_days && item.detail_days.length > 0 ? item.detail_days[0].jam_mulai : item.jam_mulai;
                    const jamSelesai = item.detail_days && item.detail_days.length > 0 ? item.detail_days[0].jam_selesai : item.jam_selesai;

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${item.tanggal_mulai}</td>
                        <td>${item.ruangan}</td>
                        <td>${jamMulai} - ${jamSelesai}</td>
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
                if (!peminjaman) return;

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
                            <span class="detail-label">Judul Kegiatan:</span>
                            <span class="detail-value">${peminjaman. judul_kegiatan}</span>
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

                    ${peminjaman.status === 'pending' ? `
                        <div class="action-buttons">
                            <button class="btn-approve" onclick="approvePeminjaman(${peminjaman.peminjaman_id})">Setuju</button>
                            <button class="btn-reject" onclick="rejectPeminjaman(${peminjaman.peminjaman_id})">Tolak</button>
                        </div>
                    ` : ''}
                `;

                document.getElementById('detail-panel').classList.add('active');
            }

            function approvePeminjaman(peminjamanId) {
                if (!confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')) return;

                // Kirim request ke server
                fetch(`/admin/approval/${peminjamanId}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Peminjaman telah disetujui dan diteruskan ke Subkoor!');
                        // Reload halaman untuk update data dari server
                        location.reload();
                    } else {
                        alert(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyetujui peminjaman.');
                });
            }

            function rejectPeminjaman(peminjamanId) {
                if (!confirm('Apakah Anda yakin ingin menolak peminjaman ini?')) return;

                const catatan = prompt('Masukkan alasan penolakan (opsional):');
                
                // Kirim request ke server
                fetch(`/admin/approval/${peminjamanId}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        catatan_penolakan: catatan
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Peminjaman telah ditolak!');
                        // Reload halaman untuk update data dari server
                        location.reload();
                    } else {
                        alert(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menolak peminjaman.');
                });
            }

            function downloadDokumen(filename) {
                alert(`Mengunduh:  ${filename}`);
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
                    const searchTerm = e.target.value. toLowerCase();
                    const rows = document.querySelectorAll('#peminjaman-tbody tr');
                    
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