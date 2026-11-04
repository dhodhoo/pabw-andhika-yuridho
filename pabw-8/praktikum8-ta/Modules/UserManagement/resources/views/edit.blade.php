@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="mb-4">
        <h4 class="mb-1">Edit User</h4>
        <p class="text-muted mb-0">Perbarui data dan role {{ $user->name }}.</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                @include('usermanagement::form', ['user' => $user])

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
