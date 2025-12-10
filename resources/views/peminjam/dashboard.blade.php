<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="display: flex; gap: 100px">
    <div class="sidebar">
        <div class="profile">
            <h1>Hallo Wok</h1>
        </div>
        <nav class="navbar">
            <ul>
                <li><a href="{{ route('peminjam.dashboard')}}">Dashboard</a></li>
                <li><a href="">Ajukan Peminjaman</a></li>
                <li><a href="">Daftar Gedung</a></li>
                <li><a href="">Notifikasi</a></li>
            </ul>
        </nav>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">
                Logout
            </button>
        </form>
    </div>
    <div>
        <h1>SIJEM</h1>
        <br><br>
        <input type="text" name="search" id="search">
        <br><br>
        <p>Daftar Ruangan Fakultas Teknik</p>
        <table border="1">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Ruangan</th>
                <th>Waktu</th>
                <th>status</th>
            </tr>
            <tr>
                <td>1</td>
                <td>12 Desember 2025</td>
                <td>C205</td>
                <td>Waktu</td>
                <td>Status</td>
            </tr>
        </table>
        <br>
        <p>Daftar Ajuan Anda</p>
        <table border="1">
            <tr>
                <th>Detail Ajuan Ruang</th>
                <th>Status</th>
                <th>Detail Ajuan</th>
            </tr>
            <tr>
                <td>C205</td>
                <td>Diajukan</td>
                <td><a href="">Lihat Detail</a></td>
            </tr>
        </table>
    </div>
</body>
</html>

