<x-dashboard-layout>
    <x-slot name="title">Step 2 - Detail Per Hari - SIPER FT Unsoed</x-slot>
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-card h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #1e1e2d;
            font-size: 24px;
            font-weight: 600;
        }

        .form-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        . progress-bar {
            width: 100%;
            height: 8px;
            background-color:  #e0e0e0;
            border-radius: 10px;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background:  linear-gradient(90deg, #3498db 0%, #2ecc71 100%);
            transition: width 0.3s ease;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }

        . form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline:  none;
            border-color:  #3498db;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size:  16px;
            cursor:  pointer;
            transition: background-color 0.3s ease;
            font-weight: 500;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .btn-success {
            background-color: #27ae60;
        }

        .btn-success:hover {
            background-color: #229954;
        }

        . summary-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom:  20px;
        }

        .summary-box h4 {
            margin:  0 0 10px 0;
            color: #1e1e2d;
            font-size: 16px;
        }

        .summary-box p {
            margin: 5px 0;
            color: #666;
            font-size: 13px;
        }
    </style>

    <div class="form-card">
        <h2>Detail Jadwal Per Hari</h2>
        <p class="form-subtitle">Hari ke-{{ $currentDay }} dari {{ $peminjaman->durasi }} hari</p>

        <div class="progress-bar">
            <div class="progress-fill" style="width: {{ ($currentDay / $peminjaman->durasi) * 100 }}%;"></div>
        </div>

        <div class="summary-box">
            <h4><i class="fas fa-info-circle" style="color: #3498db; margin-right: 8px;"></i>Informasi Peminjaman</h4>
            <p><strong>Ruangan:</strong> {{ $peminjaman->ruangan->nama_ruang }}</p>
            <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d M Y') }} - {{ \Carbon\Carbon::parse($peminjaman->tanggal_selesai)->format('d M Y') }}</p>
            <p><strong>Keperluan:</strong> {{ $peminjaman->tujuan }}</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" style="padding: 12px 15px; border-radius: 8px; margin-bottom: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach($errors->all() as $error)
                        <li style="margin-bottom: 5px;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('peminjam.ajuan.storeStep2', $peminjaman->peminjaman_id) }}" method="POST">
            @csrf

            <input type="hidden" name="hari" value="{{ $currentDay }}">

            <div class="form-group">
                <label for="tanggal">Tanggal Hari ke-{{ $currentDay }} <span style="color: red;">*</span></label>
                <input 
                    type="date" 
                    id="tanggal" 
                    name="tanggal" 
                    value="{{ old('tanggal', $defaultDate) }}" 
                    min="{{ $peminjaman->tanggal_peminjaman }}"
                    max="{{ $peminjaman->tanggal_selesai }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="jam_mulai">Jam Mulai <span style="color: red;">*</span></label>
                <input 
                    type="time" 
                    id="jam_mulai" 
                    name="jam_mulai" 
                    value="{{ old('jam_mulai', $peminjaman->jam_mulai) }}" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="jam_selesai">Jam Selesai <span style="color: red;">*</span></label>
                <input 
                    type="time" 
                    id="jam_selesai" 
                    name="jam_selesai" 
                    value="{{ old('jam_selesai', $peminjaman->jam_selesai) }}" 
                    required
                >
            </div>

            @if($currentDay < $peminjaman->durasi)
                <button type="submit" class="btn">
                    <i class="fas fa-arrow-right" style="margin-right: 8px;"></i>
                    Lanjut ke Hari {{ $currentDay + 1 }}
                </button>
            @else
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check" style="margin-right: 8px;"></i>
                    Submit Ajuan
                </button>
            @endif
        </form>
    </div>

    <x-slot name="scripts">
        <script>
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