@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="mb-4">
        <h4 class="mb-1">Tambah User</h4>
        <p class="text-muted mb-0">Akun baru dapat langsung memakai aplikasi setelah dibuat.</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                @include('usermanagement::form', ['user' => null])

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
