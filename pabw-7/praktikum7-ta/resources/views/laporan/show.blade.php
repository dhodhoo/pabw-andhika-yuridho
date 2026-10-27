<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Laporan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <table class="tabel">
                    <tr>
                        <th style="width: 30%">Nama Pelapor</th>
                        <td>{{ $laporan->nama_pelapor }}</td>
                    </tr>
                    <tr>
                        <th>Nomor HP</th>
                        <td>{{ $laporan->no_hp }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $laporan->lokasi }}</td>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td>{{ $laporan->kecamatan }}</td>
                    </tr>
                    <tr>
                        <th>Tinggi Air</th>
                        <td>{{ $laporan->tinggi_air }} cm</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $laporan->keterangan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge" style="background: {{ $laporan->badgeColor() }}">
                                {{ $laporan->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Laporan</th>
                        <td>{{ $laporan->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                </table>

                <h3 class="font-semibold mt-6 mb-2">Foto Bukti</h3>

                @if ($laporan->foto)
                    <img src="{{ asset('storage/' . $laporan->foto) }}"
                         alt="Foto laporan {{ $laporan->nama_pelapor }}"
                         style="max-width: 420px; width: 100%; border: 1px solid #d1d5db;">
                @else
                    <p class="text-gray-600">Laporan ini tidak memiliki foto.</p>
                @endif

                <div class="mt-6">
                    <a href="{{ route('laporan.edit', $laporan) }}"
                       class="tombol" style="background: #b45309">Edit</a>
                    <a href="{{ route('laporan.index') }}"
                       class="tombol" style="background: #4b5563">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
