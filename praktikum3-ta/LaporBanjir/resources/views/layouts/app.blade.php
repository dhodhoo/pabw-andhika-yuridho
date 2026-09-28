<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
            background: #f3f4f6;
            line-height: 1.6;
        }
        .container { max-width: 860px; margin: 0 auto; padding: 0 16px; }

        /* Header + navigasi */
        .site-header { background: #0ea5e9; color: #fff; }
        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            padding: 14px 0;
        }
        .brand { font-size: 20px; font-weight: bold; color: #fff; text-decoration: none; }
        .site-header nav a {
            color: #fff;
            margin-left: 16px;
            text-decoration: none;
            font-size: 15px;
        }
        .site-header nav a:hover { text-decoration: underline; }

        /* Konten */
        main { padding: 24px 0 40px; }
        h1 { font-size: 24px; margin: 0 0 8px; }
        .muted { color: #6b7280; font-size: 14px; margin-top: 0; }

        /* Kartu */
        .card {
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 14px 16px;
            margin-bottom: 12px;
        }
        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 6px;
        }
        .card p { margin: 4px 0; font-size: 14px; }
        .empty {
            background: #fff;
            border: 1px dashed #d1d5db;
            border-radius: 6px;
            padding: 16px;
            text-align: center;
            color: #6b7280;
        }

        /* Badge status */
        .badge {
            font-size: 12px;
            color: #fff;
            padding: 2px 10px;
            border-radius: 999px;
            white-space: nowrap;
        }
        .badge.waspada { background: #f59e0b; }
        .badge.siaga { background: #ea580c; }
        .badge.awas { background: #dc2626; }

        /* Form */
        form { background: #fff; border: 1px solid #d1d5db; border-radius: 6px; padding: 18px; }
        .field { margin-bottom: 14px; }
        label { display: block; font-weight: 600; margin-bottom: 4px; font-size: 15px; }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 15px;
        }
        input:focus { outline: 2px solid #0ea5e9; border-color: transparent; }
        .btn {
            display: inline-block;
            background: #0ea5e9;
            color: #fff;
            border: 0;
            padding: 9px 18px;
            border-radius: 4px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover { background: #0284c7; }

        /* Detail konfirmasi */
        .detail { background: #fff; border: 1px solid #d1d5db; border-radius: 6px; padding: 16px; }
        .detail dl { display: grid; grid-template-columns: 160px 1fr; gap: 6px 12px; margin: 0 0 16px; }
        .detail dt { font-weight: 600; }
        .detail dd { margin: 0; }
        .actions { display: flex; gap: 10px; flex-wrap: wrap; }

        /* Footer */
        .site-footer {
            background: #1f2937;
            color: #e5e7eb;
            text-align: center;
            font-size: 14px;
            padding: 12px 0;
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="{{ route('laporan.create') }}">LaporBanjir</a>
            <nav>
                <a href="{{ route('laporan.create') }}">Form Pelaporan</a>
                <a href="{{ route('laporan.index') }}">Daftar Laporan</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="site-footer">
        &copy; 2026 BPBD Kabupaten Bandung &mdash; Sistem Pelaporan Banjir LaporBanjir
    </footer>
</body>
</html>
