@extends('layouts.app')

@section('title', 'Konfirmasi Laporan')

@section('content')
    <h1>Konfirmasi Laporan</h1>

    <x-alert type="success" message="Laporan banjir berhasil dikirim. Terima kasih atas laporan Anda." />

    <div class="detail">
        <p>Berikut data laporan yang Anda kirim:</p>
        <dl>
            <dt>Nama Pelapor</dt>
            <dd>{{ $laporan['nama_pelapor'] }}</dd>

            <dt>Lokasi Kejadian</dt>
            <dd>{{ $laporan['lokasi'] }}</dd>

            <dt>Tinggi Genangan</dt>
            <dd>{{ $laporan['tinggi_genangan'] }} cm</dd>
        </dl>

        <div class="actions">
            <a href="{{ route('laporan.index') }}" class="btn">Lihat Daftar Laporan</a>
            <a href="{{ route('laporan.create') }}" class="btn">Buat Laporan Lagi</a>
        </div>
    </div>
@endsection
