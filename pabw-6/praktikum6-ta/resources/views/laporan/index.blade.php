@extends('layouts.app')

@section('title', 'Daftar Laporan Banjir')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">Daftar Laporan Banjir</h3>
            <p class="text-muted mb-0">Halaman ini hanya dapat diakses oleh petugas yang sudah login.</p>
        </div>
        <a href="{{ route('laporan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Tambah Laporan
        </a>
    </div>

    @if($laporans->isEmpty())
        <div class="alert alert-info">Belum ada laporan yang masuk.</div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @foreach($laporans as $laporan)
                @include('partials.laporan-card', ['laporan' => $laporan])
            @endforeach
        </div>
    @endif
@endsection
