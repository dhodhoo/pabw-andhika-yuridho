@extends('layouts.app')

@section('title', 'Daftar Laporan Banjir')

@section('content')
    <h1>Daftar Laporan Banjir</h1>
    <p class="muted">
        Status genangan: kurang dari 30 cm = Waspada, 30 - 70 cm = Siaga,
        lebih dari 70 cm = Bahaya.
    </p>

    @forelse ($laporans as $laporan)
        @include('partials.laporan-card', ['laporan' => $laporan])
    @empty
        <p class="empty">Belum ada laporan banjir.</p>
    @endforelse
@endsection
