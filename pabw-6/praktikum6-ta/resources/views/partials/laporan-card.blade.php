@php
    $status = $laporan->tinggi_genangan < 30
        ? 'Waspada'
        : ($laporan->tinggi_genangan <= 70 ? 'Siaga' : 'Bahaya');

    $badge = $status === 'Waspada'
        ? 'bg-warning text-dark'
        : ($status === 'Siaga' ? 'bg-orange text-dark' : 'bg-danger');
@endphp

<div class="col">
    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h5 class="card-title mb-0">{{ $laporan->nama_pelapor }}</h5>
                <span class="badge {{ $badge }}">{{ $status }}</span>
            </div>

            <p class="mb-1">
                <i class="fas fa-map-marker-alt me-1"></i>{{ $laporan->lokasi }}
            </p>
            <p class="mb-1">
                <i class="fas fa-ruler-vertical me-1"></i>{{ $laporan->tinggi_genangan }} cm
            </p>
            <p class="mb-0 text-muted">
                <i class="fas fa-calendar-day me-1"></i>{{ $laporan->tanggal_kejadian->format('d-m-Y') }}
            </p>
        </div>
    </div>
</div>
