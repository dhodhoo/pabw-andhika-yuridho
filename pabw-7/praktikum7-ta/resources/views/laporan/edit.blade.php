<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Laporan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('laporan.update', $laporan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nama_pelapor" class="block text-sm font-medium">Nama Pelapor</label>
                        <input type="text" id="nama_pelapor" name="nama_pelapor"
                               value="{{ old('nama_pelapor', $laporan->nama_pelapor) }}"
                               class="w-full border p-2">
                        @error('nama_pelapor') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="no_hp" class="block text-sm font-medium">Nomor HP</label>
                        <input type="text" id="no_hp" name="no_hp"
                               value="{{ old('no_hp', $laporan->no_hp) }}"
                               class="w-full border p-2">
                        @error('no_hp') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="lokasi" class="block text-sm font-medium">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi"
                               value="{{ old('lokasi', $laporan->lokasi) }}"
                               class="w-full border p-2">
                        @error('lokasi') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="kecamatan" class="block text-sm font-medium">Kecamatan</label>
                        <input type="text" id="kecamatan" name="kecamatan"
                               value="{{ old('kecamatan', $laporan->kecamatan) }}"
                               class="w-full border p-2">
                        @error('kecamatan') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="tinggi_air" class="block text-sm font-medium">Tinggi Air (cm)</label>
                        <input type="number" id="tinggi_air" name="tinggi_air"
                               value="{{ old('tinggi_air', $laporan->tinggi_air) }}"
                               class="w-full border p-2">
                        @error('tinggi_air') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="block text-sm font-medium">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                                  class="w-full border p-2">{{ old('keterangan', $laporan->keterangan) }}</textarea>
                        @error('keterangan') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium">Status Penanganan</label>
                        <select id="status" name="status" class="w-full border p-2">
                            @foreach (App\Models\Laporan::STATUS as $status)
                                <option value="{{ $status }}" @selected(old('status', $laporan->status) === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <p class="text-sm">Foto saat ini:</p>
                        @if ($laporan->foto)
                            <img src="{{ asset('storage/' . $laporan->foto) }}"
                                 alt="Foto laporan {{ $laporan->nama_pelapor }}"
                                 width="160" style="border: 1px solid #d1d5db;">
                        @else
                            <p class="text-gray-600 text-sm">Belum ada foto.</p>
                        @endif
                        <label for="foto" class="block text-sm font-medium mt-2">
                            Ganti Foto (kosongkan jika tidak diganti, maks. 2 MB)
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*" class="w-full">
                        @error('foto') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="tombol" style="background: #1d4ed8; border: 0;">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('laporan.index') }}" class="ms-3 text-gray-600">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
