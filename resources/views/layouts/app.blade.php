<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LaporBanjir') - BPBD Kabupaten Bandung</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #eef6fc;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #1565c0;
            color: white;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            flex-wrap: wrap;
            gap: 12px;
        }

        header h1 {
            font-size: 1.4rem;
        }

        header h1 a {
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        nav {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        nav a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        nav a:hover {
            color: #bbdefb;
        }

        .nav-logout-btn {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nav-logout-btn:hover {
            background: #d32f2f;
            border-color: #d32f2f;
            color: #ffffff;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 20px;
        }

        .container {
            background-color: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 32px 28px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(25, 118, 210, 0.12);
            border: 2px solid #bbdefb;
        }

        .container-wide { max-width: 1000px; }

        h2 {
            color: #1565c0;
            text-align: center;
            margin-bottom: 24px;
            font-size: 1.5rem;
        }

        footer {
            background-color: #0d47a1;
            color: #ffffff;
            text-align: center;
            padding: 14px;
            font-size: 0.85rem;
        }

        /* Utility Form Styles */
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; color: #0d47a1; font-weight: 600; font-size: 0.9rem; }
        input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="date"], input[type="tel"], select, textarea {
            width: 100%; padding: 12px 14px; border: 1.5px solid #90caf9;
            border-radius: 10px; font-size: 0.95rem; outline: none; background-color: #f7faff;
        }
        input:focus, select:focus, textarea:focus { border-color: #1e88e5; background-color: #fff; }
        input[type="file"] { width: 100%; padding: 10px; border: 1.5px dashed #90caf9; border-radius: 10px; background: #f7faff; }
        textarea { resize: vertical; min-height: 90px; }
        .is-invalid { border-color: #d32f2f !important; }
        .error-text { color: #c62828; font-size: 0.82rem; margin-top: 5px; }
        .hint { color: #666; font-size: 0.8rem; margin-top: 4px; }
        .btn {
            display: block; width: 100%; padding: 12px; background-color: #1976d2; color: white;
            text-align: center; border: none; border-radius: 10px; font-size: 1rem; font-weight: 600;
            cursor: pointer; text-decoration: none; transition: background-color 0.2s;
        }
        .btn:hover { background-color: #1565c0; }

        /* Badge Status */
        .status-badge {
            padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: bold; color: white;
        }
        .waspada { background-color: #fbc02d; color: #333; } /* Yellow */
        .siaga { background-color: #f57c00; } /* Orange */
        .awas { background-color: #d32f2f; } /* Red */

        /* Alert Notifications */
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .alert-danger {
            background-color: #ffebee;
            border: 1px solid #ef9a9a;
            color: #b71c1c;
        }
        .alert-success {
            background-color: #e8f5e9;
            border: 1px solid #a5d6a7;
            color: #1b5e20;
        }
        /* Badge status penanganan */
        .menunggu { background-color: #fbc02d; color: #333; }
        .diproses { background-color: #1e88e5; }
        .selesai { background-color: #2e7d32; }

        /* Tabel & aksi */
        .table-wrap { overflow-x: auto; }
        table.data { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        table.data th { background: #e3f2fd; color: #0d47a1; text-align: left; padding: 10px; }
        table.data td { padding: 10px; border-bottom: 1px solid #e0e0e0; vertical-align: middle; }
        .thumb { width: 80px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #bbdefb; }
        .thumb-empty { width: 80px; height: 60px; border-radius: 8px; background: #eceff1; color: #78909c;
                       display: flex; align-items: center; justify-content: center; font-size: 0.7rem; }
        .actions { display: flex; gap: 6px; flex-wrap: wrap; }
        .btn-sm { display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 600;
                  border: none; cursor: pointer; text-decoration: none; color: #fff; }
        .btn-info { background: #1976d2; } .btn-warn { background: #f57c00; } .btn-danger { background: #d32f2f; }
        .btn-secondary { background: #607d8b; }
        .btn-inline { display: inline-block; width: auto; padding: 10px 20px; }

        /* Detail */
        .detail-grid { display: grid; grid-template-columns: 180px 1fr; gap: 10px 16px; margin: 18px 0; }
        .detail-grid dt { font-weight: 600; color: #0d47a1; }
        .foto-detail { max-width: 100%; max-height: 380px; border-radius: 12px; border: 2px solid #bbdefb; }

        /* Pagination */
        .pagination { display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; margin-top: 20px; }
        .pagination .page { padding: 7px 13px; border-radius: 8px; border: 1px solid #90caf9; background: #fff;
                            color: #1565c0; text-decoration: none; font-size: 0.85rem; font-weight: 600; }
        .pagination .page.active { background: #1565c0; color: #fff; border-color: #1565c0; }
        .pagination .page.disabled { color: #aaa; border-color: #ddd; }

        @media (max-width: 600px) { .detail-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <header>
        <h1><a href="{{ route('lapor.create') }}">LaporBanjir</a></h1>
        <nav>
            <a href="{{ route('lapor.create') }}">Buat Laporan</a>

            @auth
                <a href="{{ route('laporan.index') }}">Kelola Laporan</a>
                <a href="{{ route('petugas.profile') }}">Profil Petugas</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline-block;">
                    @csrf
                    <button type="submit" class="nav-logout-btn">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} BPBD Kabupaten Bandung. All Rights Reserved.
    </footer>

</body>
</html>