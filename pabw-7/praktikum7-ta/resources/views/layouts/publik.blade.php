<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'LaporBanjir')</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; background: #f3f4f6; margin: 0; color: #111827; }
        header { background: #1d4ed8; color: #ffffff; padding: 14px 20px; }
        header strong { font-size: 18px; }
        header span { font-size: 13px; }
        main { max-width: 640px; margin: 24px auto; background: #ffffff; padding: 24px; border: 1px solid #d1d5db; }
        h1 { font-size: 20px; margin-top: 0; }
        p { font-size: 14px; line-height: 1.5; }
        label { display: block; margin: 14px 0 4px; font-weight: bold; font-size: 14px; }
        input, textarea { width: 100%; padding: 8px; border: 1px solid #9ca3af; box-sizing: border-box; font: inherit; }
        textarea { height: 80px; }
        .galat { color: #b91c1c; font-size: 13px; margin-top: 4px; }
        .tombol { background: #1d4ed8; color: #ffffff; border: 0; padding: 10px 18px; margin-top: 18px; cursor: pointer; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        .info { background: #ecfdf5; border: 1px solid #6ee7b7; padding: 12px; margin-bottom: 16px; }
    </style>
</head>
<body>
    <header>
        <strong>LaporBanjir</strong>
        <span>Badan Penanggulangan Bencana Daerah Kabupaten Bandung</span>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
