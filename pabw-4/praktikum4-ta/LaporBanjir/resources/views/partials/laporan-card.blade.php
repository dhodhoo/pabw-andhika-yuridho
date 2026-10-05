<article class="card">
    <div class="card-head">
        <strong>{{ $laporan->lokasi }}</strong>

        @if ($laporan->tinggi_genangan < 30)
            <span class="badge waspada">Waspada</span>
        @elseif ($laporan->tinggi_genangan <= 70)
            <span class="badge siaga">Siaga</span>
        @else
            <span class="badge awas">Bahaya</span>
        @endif
    </div>

    <p><strong>Pelapor:</strong> {{ $laporan->nama_pelapor }}</p>
    <p><strong>Tinggi genangan:</strong> {{ $laporan->tinggi_genangan }} cm</p>
    <p><strong>Tanggal kejadian:</strong> {{ $laporan->tanggal_kejadian }}</p>
</article>
