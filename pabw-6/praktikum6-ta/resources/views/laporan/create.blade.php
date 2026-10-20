@extends('layouts.app')

@section('title', 'Form Pelaporan Banjir')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Form Pelaporan Banjir</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Sampaikan laporan genangan atau banjir di wilayah Kabupaten Bandung.
                        Laporan dapat dikirim tanpa login.
                    </p>

                    <form method="POST" action="{{ route('laporan.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_pelapor" class="form-label">Nama Pelapor</label>
                            <input id="nama_pelapor" type="text" name="nama_pelapor"
                                   @class(['form-control', 'is-invalid' => $errors->has('nama_pelapor')])
                                   value="{{ old('nama_pelapor') }}" required>
                            @error('nama_pelapor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lokasi" class="form-label">Lokasi Kejadian</label>
                                <input id="lokasi" type="text" name="lokasi"
                                       @class(['form-control', 'is-invalid' => $errors->has('lokasi')])
                                       value="{{ old('lokasi') }}" required>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tinggi_genangan" class="form-label">
                                    Tinggi Genangan (cm)
                                </label>
                                <input id="tinggi_genangan" type="number" name="tinggi_genangan" min="0"
                                       @class(['form-control', 'is-invalid' => $errors->has('tinggi_genangan')])
                                       value="{{ old('tinggi_genangan') }}" required>
                                @error('tinggi_genangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian</label>
                            <input id="tanggal_kejadian" type="date" name="tanggal_kejadian"
                                   @class(['form-control', 'is-invalid' => $errors->has('tanggal_kejadian')])
                                   value="{{ old('tanggal_kejadian') }}" required>
                            @error('tanggal_kejadian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Kirim Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
