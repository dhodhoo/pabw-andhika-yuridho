<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Laporan Banjir
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 p-3" style="background: #dcfce7; color: #166534;">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="tabel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama Pelapor</th>
                            <th>Lokasi</th>
                            <th>Kecamatan</th>
                            <th>Tinggi Air</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporans as $laporan)
                            <tr>
                                <td>{{ $laporans->firstItem() + $loop->index }}</td>
                                <td>
                                    @if ($laporan->foto)
                                        <img src="{{ asset('storage/' . $laporan->foto) }}"
                                             alt="Foto laporan {{ $laporan->nama_pelapor }}"
                                             width="70" height="50" style="object-fit: cover;">
                                    @else
                                        <span class="text-gray-500">Tidak ada</span>
                                    @endif
                                </td>
                                <td>{{ $laporan->nama_pelapor }}</td>
                                <td>{{ $laporan->lokasi }}</td>
                                <td>{{ $laporan->kecamatan }}</td>
                                <td>{{ $laporan->tinggi_air }} cm</td>
                                <td>
                                    <span class="badge" style="background: {{ $laporan->badgeColor() }}">
                                        {{ $laporan->status }}
                                    </span>
                                </td>
                                <td>{{ $laporan->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('laporan.show', $laporan) }}" style="color: #0369a1">Lihat</a> |
                                    <a href="{{ route('laporan.edit', $laporan) }}" style="color: #b45309">Edit</a> |
                                    <form action="{{ route('laporan.destroy', $laporan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="color: #b91c1c; background: none; border: 0; padding: 0; cursor: pointer"
                                                onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada laporan yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $laporans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
