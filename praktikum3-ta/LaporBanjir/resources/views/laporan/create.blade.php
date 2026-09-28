@extends('layouts.app')

@section('title', 'Form Pelaporan Banjir')

@section('content')
    <h1>Form Pelaporan Banjir</h1>
    <p class="muted">Laporkan kejadian banjir di wilayah Anda.</p>

    <form method="POST" action="{{ route('laporan.store') }}">
        @csrf

        <div class="field">
            <label for="nama_pelapor">Nama Pelapor</label>
            <input type="text" id="nama_pelapor" name="nama_pelapor"
                   placeholder="Contoh: Budi Santoso">
        </div>

        <div class="field">
            <label for="lokasi">Lokasi Kejadian</label>
            <input type="text" id="lokasi" name="lokasi"
                   placeholder="Contoh: Jl. Sukajadi No. 12, Bandung">
        </div>

        <div class="field">
            <label for="tinggi_genangan">Tinggi Genangan Air (cm)</label>
            <input type="number" id="tinggi_genangan" name="tinggi_genangan" min="1"
                   placeholder="Contoh: 45">
        </div>

        <button type="submit" class="btn">Kirim Laporan</button>
    </form>
@endsection
