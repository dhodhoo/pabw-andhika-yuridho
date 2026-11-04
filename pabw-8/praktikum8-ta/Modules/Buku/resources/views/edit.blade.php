@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
    <div class="mb-4">
        <h4 class="mb-1">Edit Buku</h4>
        <p class="text-muted mb-0">Perbarui data {{ $buku->judul }}.</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('buku.update', $buku) }}">
                @csrf
                @method('PUT')
                @include('buku::form', ['buku' => $buku])

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
