@extends('layouts.publik')

@section('title', 'Laporan Terkirim')

@section('content')
    <h1>Laporan Berhasil Dikirim</h1>

    <div class="info">
        Terima kasih, {{ $laporan->nama_pelapor }}. Laporan Anda sudah masuk ke BPBD Kabupaten
        Bandung dengan nomor {{ $laporan->id }} dan status awal {{ $laporan->status }}.
    </div>

    <table>
        <tr>
            <th>Lokasi</th>
            <td>{{ $laporan->lokasi }}</td>
        </tr>
        <tr>
            <th>Kecamatan</th>
            <td>{{ $laporan->kecamatan }}</td>
        </tr>
        <tr>
            <th>Tinggi Air</th>
            <td>{{ $laporan->tinggi_air }} cm</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $laporan->status }}</td>
        </tr>
    </table>

    <p style="margin-top: 18px">
        <a href="{{ route('laporan.create') }}">Kirim laporan lain</a>
    </p>
@endsection
