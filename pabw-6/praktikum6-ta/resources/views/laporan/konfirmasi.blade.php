@extends('layouts.app')

@section('title', 'Laporan Terkirim')

@section('content')
    @php
        $status = $laporan->tinggi_genangan < 30
            ? 'Waspada'
            : ($laporan->tinggi_genangan <= 70 ? 'Siaga' : 'Bahaya');

        $badge = $status === 'Waspada'
            ? 'bg-warning text-dark'
            : ($status === 'Siaga' ? 'bg-orange text-dark' : 'bg-danger');
    @endphp

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <x-alert type="success">Laporan banjir berhasil disimpan.</x-alert>

            <div class="card">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Detail Laporan</h4>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nama Pelapor</dt>
                        <dd class="col-sm-8">{{ $laporan->nama_pelapor }}</dd>

                        <dt class="col-sm-4">Lokasi Kejadian</dt>
                        <dd class="col-sm-8">{{ $laporan->lokasi }}</dd>

                        <dt class="col-sm-4">Tinggi Genangan</dt>
                        <dd class="col-sm-8">{{ $laporan->tinggi_genangan }} cm</dd>

                        <dt class="col-sm-4">Tanggal Kejadian</dt>
                        <dd class="col-sm-8">{{ $laporan->tanggal_kejadian->format('d-m-Y') }}</dd>

                        <dt class="col-sm-4">Status Genangan</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ $badge }}">{{ $status }}</span>
                        </dd>
                    </dl>

                    <div class="mt-4">
                        <a href="{{ route('laporan.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>Kirim Laporan Lain
                        </a>
                        <a href="{{ route('laporan.index') }}" class="btn btn-primary">
                            <i class="fas fa-list me-1"></i>Lihat Daftar Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
