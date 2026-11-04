@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
    <div class="mb-4">
        <h4 class="mb-1">Tambah Buku</h4>
        <p class="text-muted mb-0">Isi data buku yang akan ditambahkan ke koleksi.</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('buku.store') }}">
                @csrf
                @include('buku::form', ['buku' => null])

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
