@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h4 class="mb-1">Daftar Buku</h4>
            <p class="text-muted mb-0">Koleksi buku perpustakaan kampus.</p>
        </div>
        @if (auth()->user()->isAdmin())
            <a href="{{ route('buku.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Buku
            </a>
        @endif
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <form method="GET" action="{{ route('buku.index') }}" class="d-flex gap-2">
                <input type="search" name="q" value="{{ $search }}" class="form-control form-control-sm"
                    placeholder="Cari judul, penulis, penerbit" style="min-width: 240px">
                <button type="submit" class="btn btn-outline-primary btn-sm">Cari</button>
                @if ($search !== '')
                    <a href="{{ route('buku.index') }}" class="btn btn-light btn-sm">Reset</a>
                @endif
            </form>
            <span class="text-muted small">{{ $bukus->total() }} buku</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        @if (auth()->user()->isAdmin())
                            <th class="text-end">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bukus as $buku)
                        <tr>
                            <td>{{ $bukus->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold">{{ $buku->judul }}</td>
                            <td>{{ $buku->penulis }}</td>
                            <td>{{ $buku->penerbit }}</td>
                            <td>{{ $buku->tahun_terbit }}</td>
                            <td>
                                <span class="badge {{ $buku->stok > 0 ? 'text-bg-success' : 'text-bg-secondary' }}">
                                    {{ $buku->stok }}
                                </span>
                            </td>
                            @if (auth()->user()->isAdmin())
                                <td class="text-end">
                                    <a href="{{ route('buku.edit', $buku) }}" class="btn btn-sm btn-light">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('buku.destroy', $buku) }}" class="d-inline"
                                        data-confirm="Buku &quot;{{ $buku->judul }}&quot; akan dihapus.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}">
                                <div class="empty-state">
                                    <i class="bi bi-journal-x d-block mb-2"></i>
                                    Tidak ada buku yang cocok dengan pencarian.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($bukus->hasPages())
            <div class="card-footer bg-white">
                {{ $bukus->links() }}
            </div>
        @endif
    </div>
@endsection
