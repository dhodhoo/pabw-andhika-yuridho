@extends('layouts.publik')

@section('title', 'Lapor Banjir')

@section('content')
    <h1>Form Pelaporan Banjir</h1>
    <p>
        Isi data kejadian banjir di sekitar Anda. Laporan yang masuk akan diperiksa petugas BPBD
        dan statusnya diperbarui sampai penanganan selesai.
    </p>

    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="nama_pelapor">Nama Pelapor</label>
        <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}">
        @error('nama_pelapor') <div class="galat">{{ $message }}</div> @enderror

        <label for="no_hp">Nomor HP</label>
        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}">
        @error('no_hp') <div class="galat">{{ $message }}</div> @enderror

        <label for="lokasi">Lokasi Kejadian</label>
        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}">
        @error('lokasi') <div class="galat">{{ $message }}</div> @enderror

        <label for="kecamatan">Kecamatan</label>
        <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}">
        @error('kecamatan') <div class="galat">{{ $message }}</div> @enderror

        <label for="tinggi_air">Tinggi Air (cm)</label>
        <input type="number" id="tinggi_air" name="tinggi_air" value="{{ old('tinggi_air') }}">
        @error('tinggi_air') <div class="galat">{{ $message }}</div> @enderror

        <label for="keterangan">Keterangan (opsional)</label>
        <textarea id="keterangan" name="keterangan">{{ old('keterangan') }}</textarea>
        @error('keterangan') <div class="galat">{{ $message }}</div> @enderror

        <label for="foto">Foto Kondisi Banjir (jpg, jpeg, png, maks. 2 MB)</label>
        <input type="file" id="foto" name="foto" accept="image/*">
        @error('foto') <div class="galat">{{ $message }}</div> @enderror

        <button type="submit" class="tombol">Kirim Laporan</button>
    </form>
@endsection
