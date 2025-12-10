<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SIPER - Dashboard' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #e8eaf6;
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 200px;
            background-color:  #1e1e2d;
            min-height: 100vh;
            padding: 20px 0;
            position: fixed;
            left: 0;
            top:  0;
            display: flex;
            flex-direction: column;
        }

        .profile-section {
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background-color: #d1d1d1;
            border-radius: 50%;
            margin: 0 auto 10px;
        }

        .profile-label {
            color: #fff;
            font-size: 14px;
        }

        .nav-menu {
            list-style: none;
            flex-grow: 1;
        }

        .nav-item {
            padding: 12px 25px;
            display: flex;
            align-items: center;
            color: #a2a3b7;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .nav-item:hover, .nav-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .nav-item i {
            margin-right: 12px;
            font-size:  16px;
            width: 20px;
        }

        .nav-item span {
            font-size: 14px;
        }

        .logout-btn {
            padding: 12px 25px;
            display: flex;
            align-items: center;
            color: #f64e60;
            cursor: pointer;
            margin-top: auto;
            transition: all 0.3s ease;
            border: none;
            background:  none;
            width: 100%;
        }

        .logout-btn:hover {
            background-color:  rgba(246, 78, 96, 0.1);
        }

        . logout-btn i {
            margin-right: 12px;
        }

        /* Main Content Styles */
        . main-content {
            margin-left: 200px;
            flex-grow: 1;
            padding: 40px;
        }

        .header-title {
            text-align: center;
            font-size: 36px;
            font-weight:  700;
            color: #1e1e2d;
            margin-bottom: 30px;
            letter-spacing: 8px;
        }

        . content-wrapper {
            display: flex;
            gap: 20px;
        }

        . left-panel {
            flex:  1;
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow:  0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .right-panel {
            width: 400px;
            background-color:  #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: none;
        }

        .right-panel.active {
            display: block;
        }

        .panel-title {
            font-size: 20px;
            font-weight:  600;
            color: #1e1e2d;
            margin-bottom: 20px;
        }

        /* Search Bar */
        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size:  14px;
        }

        /* Table Styles */
        .peminjaman-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .peminjaman-table thead {
            background-color: #f8f9fa;
        }

        .peminjaman-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #1e1e2d;
            font-size: 14px;
            border-bottom: 2px solid #e0e0e0;
        }

        .peminjaman-table td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #333;
        }

        .peminjaman-table tbody tr {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .peminjaman-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .peminjaman-table tbody tr.selected {
            background-color: #e3f2fd;
        }

        . btn-detail {
            padding: 6px 16px;
            background-color: #1e1e2d;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-detail:hover {
            background-color: #333;
        }

        . status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius:  12px;
            font-size:  12px;
            font-weight: 500;
        }

        . status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        . status-approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background-color:  #f8d7da;
            color: #721c24;
        }

        /* Detail Panel */
        .detail-section {
            margin-bottom: 25px;
        }

        . detail-section h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1e1e2d;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e0e0e0;
        }

        . detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-label {
            font-weight: 500;
            color:  #666;
            font-size: 13px;
        }

        . detail-value {
            font-weight: 600;
            color: #1e1e2d;
            font-size: 13px;
            text-align: right;
        }

        .schedule-list {
            margin-top: 10px;
        }

        . schedule-item {
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .schedule-item-title {
            font-weight: 600;
            color: #1e1e2d;
            font-size: 13px;
            margin-bottom: 6px;
        }

        . schedule-item-detail {
            font-size: 12px;
            color: #666;
            margin-bottom: 3px;
        }

        . action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        . btn-approve {
            flex: 1;
            padding:  12px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-approve:hover {
            background-color: #218838;
        }

        .btn-reject {
            flex: 1;
            padding:  12px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-reject:hover {
            background-color: #c82333;
        }

        .dokumen-section {
            margin-top: 15px;
        }

        . dokumen-link {
            display: inline-block;
            padding: 8px 16px;
            background-color: #f0f0f0;
            color: #1e1e2d;
            text-decoration: none;
            border-radius: 5px;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }

        .dokumen-link:hover {
            background-color:  #e0e0e0;
        }

        /* Page Management */
        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        /* Arsip Styles */
        .arsip-container, .archive-container {
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .archive-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .archive-table thead {
            background-color: #f8f9fa;
        }

        .archive-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color:  #1e1e2d;
            font-size: 14px;
            border-bottom:  2px solid #e0e0e0;
        }

        .archive-table td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #333;
        }

        .archive-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .archive-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .content-wrapper {
                flex-direction: column;
            }

            .right-panel {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding: 10px 0;
            }

            . profile-label, .nav-item span, .logout-btn span {
                display: none;
            }

            .nav-item, .logout-btn {
                justify-content: center;
                padding: 15px;
            }

            .nav-item i, .logout-btn i {
                margin-right: 0;
                font-size: 18px;
            }

            . profile-avatar {
                width: 50px;
                height: 50px;
            }

            .main-content {
                margin-left: 70px;
                padding: 20px;
            }

            . header-title {
                font-size: 24px;
                letter-spacing: 4px;
            }

            . peminjaman-table {
                font-size: 12px;
            }

            . peminjaman-table th,
            .peminjaman-table td {
                padding: 8px;
            }

            .archive-table {
                font-size: 12px;
            }

            .archive-table th,
            .archive-table td {
                padding: 8px;
            }
        }
    </style>
    {{ $styles ??  '' }}
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="profile-section">
            <div class="profile-avatar"></div>
            <span class="profile-label">{{ $profileLabel ?? 'User' }}</span>
        </div>

        <ul class="nav-menu">
            {{ $navigation }}
        </ul>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Log Out</span>
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <h1 class="header-title">SIPER</h1>

        {{ $slot }}
    </main>

    {{ $scripts ?? '' }}
</body>
</html>