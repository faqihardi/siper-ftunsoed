<x-dashboard-layout>
    <x-slot name="title">Ajukan Peminjaman - SIPER FT Unsoed</x-slot>
    <x-slot name="profileLabel">{{ Auth::user()->nama_user }}</x-slot>
    
    <x-slot name="navigation">
        <ul>
            <li><a href="{{ route('peminjam.dashboard') }}" class="nav-item">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a></li>
            <li><a href="{{ route('peminjam.ajuan.create') }}" class="nav-item active">
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
        .form-card {
            background-color: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow:  0 2px 10px rgba(0, 0, 0, 0.05);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-card h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #1e1e2d;
            font-size: 24px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        . form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }

        . form-group input, 
        .form-group select, 
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus, 
        . form-group select:focus, 
        .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .upload-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            cursor: pointer;
            color: #666;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        . upload-button:hover {
            border-color: #3498db;
            background-color: #e3f2fd;
        }

        .upload-button i {
            margin-right: 8px;
            color: #3498db;
        }

        .file-name {
            margin-top: 8px;
            font-size:  12px;
            color: #666;
            font-style: italic;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background-color:  #3498db;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size:  16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 500;
            margin-top: 10px;
        }

        . btn:hover {
            background-color: #2980b9;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .error-list li {
            margin-bottom: 5px;
        }

        .form-helper {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>

    <div class="form-card">
        <h2>Formulir Ajuan Peminjaman Ruangan</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('peminjam.ajuan.storeStep1') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="ruang_id">Ruangan <span style="color: red;">*</span></label>
                <select id="ruang_id" name="ruang_id" required>
                    <option value="" disabled {{ old('ruang_id', request('ruang_id')) ? '' : 'selected' }}>Pilih ruangan</option>
                    @foreach($ruangans as $ruangan)
                        <option 
                            value="{{ $ruangan->ruang_id }}" 
                            {{ old('ruang_id', request('ruang_id')) == $ruangan->ruang_id ? 'selected' : '' }}
                        >
                            {{ $ruangan->nama_ruang }} - {{ $ruangan->gedung->nama_gedung }} (Kapasitas: {{ $ruangan->kapasitas }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal_peminjaman">Tanggal Mulai <span style="color: red;">*</span></label>
                <input 
                    type="date" 
                    id="tanggal_peminjaman" 
                    name="tanggal_peminjaman" 
                    value="{{ old('tanggal_peminjaman') }}" 
                    min="{{ date('Y-m-d') }}"
                    required
                >
                <div class="form-helper">Tanggal mulai peminjaman</div>
            </div>

            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai <span style="color:  red;">*</span></label>
                <input 
                    type="date" 
                    id="tanggal_selesai" 
                    name="tanggal_selesai" 
                    value="{{ old('tanggal_selesai') }}" 
                    min="{{ date('Y-m-d') }}"
                    required
                >
                <div class="form-helper">Tanggal selesai peminjaman</div>
            </div>

            <div class="form-group">
                <label for="jam_mulai">Jam Mulai <span style="color: red;">*</span></label>
                <input 
                    type="time" 
                    id="jam_mulai" 
                    name="jam_mulai" 
                    value="{{ old('jam_mulai', '08:00') }}" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="jam_selesai">Jam Selesai <span style="color: red;">*</span></label>
                <input 
                    type="time" 
                    id="jam_selesai" 
                    name="jam_selesai" 
                    value="{{ old('jam_selesai', '17:00') }}" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="tujuan">Keperluan <span style="color:  red;">*</span></label>
                <select id="tujuan" name="tujuan" required>
                    <option value="" disabled {{ old('tujuan') ? '' : 'selected' }}>Pilih keperluan</option>
                    <option value="Pertemuan" {{ old('tujuan') == 'Pertemuan' ? 'selected' : '' }}>Pertemuan</option>
                    <option value="Workshop" {{ old('tujuan') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="Rapat" {{ old('tujuan') == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                    <option value="Seminar" {{ old('tujuan') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                    <option value="Kuliah Pengganti" {{ old('tujuan') == 'Kuliah Pengganti' ? 'selected' : '' }}>Kuliah Pengganti</option>
                    <option value="Lainnya" {{ old('tujuan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="detail_kegiatan">Judul/Detail Kegiatan <span style="color: red;">*</span></label>
                <textarea 
                    id="detail_kegiatan" 
                    name="detail_kegiatan" 
                    required
                    placeholder="Jelaskan detail kegiatan yang akan dilakukan..."
                >{{ old('detail_kegiatan') }}</textarea>
            </div>

            <div class="form-group">
                <label>Dokumen Pendukung (Opsional)</label>
                <div class="upload-button" onclick="document.getElementById('file-input').click();">
                    <input type="file" id="file-input" name="dokumen_pendukung" style="display: none;" accept=".pdf,. doc,.docx,. jpg,.jpeg,.png" />
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span id="upload-text">Upload File (PDF, DOC, JPG, PNG - Max 2MB)</span>
                </div>
                <div class="file-name" id="file-name"></div>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-arrow-right" style="margin-right: 8px;"></i>
                Lanjut ke Step 2
            </button>
        </form>
    </div>

    <x-slot name="scripts">
        <script>
            // File upload handler
            document.getElementById('file-input').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileName = file.name;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
                    
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar!  Maksimal 2MB');
                        this.value = '';
                        document.getElementById('file-name').textContent = '';
                        document.getElementById('upload-text').textContent = 'Upload File (PDF, DOC, JPG, PNG - Max 2MB)';
                        return;
                    }
                    
                    document.getElementById('file-name').textContent = `${fileName} (${fileSize} MB)`;
                    document.getElementById('upload-text').textContent = 'File dipilih ✓';
                }
            });

            // Date validation
            document.getElementById('tanggal_selesai').addEventListener('change', function() {
                const startDate = document.getElementById('tanggal_peminjaman').value;
                const endDate = this.value;
                
                if (startDate && endDate && endDate < startDate) {
                    alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai! ');
                    this.value = startDate;
                }
            });

            // Time validation
            document.getElementById('jam_selesai').addEventListener('change', function() {
                const startTime = document.getElementById('jam_mulai').value;
                const endTime = this.value;
                
                if (startTime && endTime && endTime <= startTime) {
                    alert('Jam selesai harus lebih besar dari jam mulai!');
                    this.value = '';
                }
            });
        </script>
    </x-slot>
</x-dashboard-layout>