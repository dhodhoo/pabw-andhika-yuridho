@extends('layouts.app')

@section('title', 'Peminjaman')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h4 class="mb-1">Peminjaman Buku</h4>
            <p class="text-muted mb-0">Catatan peminjaman yang dikelola tanpa memuat ulang halaman.</p>
        </div>
        <button type="button" class="btn btn-primary" id="btnTambah">
            <i class="bi bi-plus-lg me-1"></i>Tambah Peminjaman
        </button>
    </div>

    <div id="pageAlert"></div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody id="peminjamanRows">
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="peminjamanModal" tabindex="-1" aria-labelledby="peminjamanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="peminjamanForm" enctype="multipart/form-data" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title" id="peminjamanModalLabel">Tambah Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_peminjam" class="form-label">Nama Peminjam <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                                <div class="invalid-feedback" id="error-nama_peminjam"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="judul_buku" class="form-label">Judul Buku <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="judul_buku" name="judul_buku" required>
                                <div class="invalid-feedback" id="error-judul_buku"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
                                <div class="invalid-feedback" id="error-tanggal_pinjam"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_kembali" class="form-label">Tanggal Kembali <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                                    required>
                                <div class="invalid-feedback" id="error-tanggal_kembali"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Dipinjam">Dipinjam</option>
                                    <option value="Dikembalikan">Dikembalikan</option>
                                </select>
                                <div class="invalid-feedback" id="error-status"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="bukti" class="form-label">Bukti Peminjaman</label>
                                <input type="file" class="form-control" id="bukti" name="bukti"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                <div class="form-text">jpg, jpeg, png, atau pdf. Maksimal 2 MB.</div>
                                <div class="invalid-feedback" id="error-bukti"></div>
                                <div class="mt-1 small d-none" id="buktiLama"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            const urls = {
                data: '{{ route('peminjaman.data') }}',
                store: '{{ route('peminjaman.store') }}',
                base: '{{ url('peminjamans') }}',
            };

            const modalElement = document.getElementById('peminjamanModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            const form = document.getElementById('peminjamanForm');
            let editingId = null;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                },
            });

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, function (char) {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;',
                    }[char];
                });
            }

            function clearErrors() {
                form.querySelectorAll('.is-invalid').forEach(function (input) {
                    input.classList.remove('is-invalid');
                });
                form.querySelectorAll('[id^="error-"]').forEach(function (box) {
                    box.textContent = '';
                });
            }

            function showErrors(errors) {
                Object.keys(errors).forEach(function (field) {
                    const input = form.querySelector('[name="' + field + '"]');
                    const box = document.getElementById('error-' + field);

                    if (input) {
                        input.classList.add('is-invalid');
                    }

                    if (box) {
                        box.textContent = errors[field][0];
                    }
                });
            }

            function showAlert(message, type) {
                $('#pageAlert').html(
                    '<div class="alert alert-' + type + ' alert-dismissible fade show d-flex align-items-center gap-2" role="alert">' +
                        '<i class="bi bi-check-circle"></i><span>' + escapeHtml(message) + '</span>' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>' +
                    '</div>'
                );
            }

            function statusBadge(status) {
                const css = status === 'Dikembalikan' ? 'text-bg-success' : 'text-bg-warning';
                return '<span class="badge ' + css + '">' + escapeHtml(status) + '</span>';
            }

            function renderRow(peminjaman, index) {
                const bukti = peminjaman.bukti_url
                    ? '<a href="' + escapeHtml(peminjaman.bukti_url) + '" target="_blank" rel="noopener">Lihat berkas</a>'
                    : '<span class="text-muted">-</span>';

                return '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + escapeHtml(peminjaman.nama_peminjam) + '</td>' +
                    '<td>' + escapeHtml(peminjaman.judul_buku) + '</td>' +
                    '<td>' + escapeHtml(peminjaman.tanggal_pinjam) + '</td>' +
                    '<td>' + escapeHtml(peminjaman.tanggal_kembali) + '</td>' +
                    '<td>' + statusBadge(peminjaman.status) + '</td>' +
                    '<td>' + bukti + '</td>' +
                    '<td class="text-end">' +
                        '<button type="button" class="btn btn-sm btn-light btn-edit" data-id="' + peminjaman.id + '">' +
                            '<i class="bi bi-pencil"></i> Edit</button> ' +
                        '<button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="' + peminjaman.id + '">' +
                            '<i class="bi bi-trash"></i> Hapus</button>' +
                    '</td>' +
                    '</tr>';
            }

            function loadData() {
                $.getJSON(urls.data)
                    .done(function (response) {
                        const rows = response.data || [];

                        if (rows.length === 0) {
                            $('#peminjamanRows').html(
                                '<tr><td colspan="8" class="text-center text-muted py-4">Belum ada data peminjaman.</td></tr>'
                            );
                            return;
                        }

                        $('#peminjamanRows').html(rows.map(renderRow).join(''));
                    })
                    .fail(function () {
                        $('#peminjamanRows').html(
                            '<tr><td colspan="8" class="text-center text-danger py-4">Gagal memuat data.</td></tr>'
                        );
                    });
            }

            $('#btnTambah').on('click', function () {
                editingId = null;
                form.reset();
                clearErrors();
                $('#peminjamanModalLabel').text('Tambah Peminjaman');
                $('#buktiLama').addClass('d-none').empty();
                modal.show();
            });

            $(document).on('click', '.btn-edit', function () {
                const id = $(this).data('id');

                $.getJSON(urls.base + '/' + id)
                    .done(function (peminjaman) {
                        editingId = peminjaman.id;
                        clearErrors();
                        form.reset();
                        $('#nama_peminjam').val(peminjaman.nama_peminjam);
                        $('#judul_buku').val(peminjaman.judul_buku);
                        $('#tanggal_pinjam').val(peminjaman.tanggal_pinjam);
                        $('#tanggal_kembali').val(peminjaman.tanggal_kembali);
                        $('#status').val(peminjaman.status);
                        $('#peminjamanModalLabel').text('Edit Peminjaman');
                        $('#buktiLama').removeClass('d-none').html(
                            peminjaman.bukti_url
                                ? 'Berkas saat ini: <a href="' + escapeHtml(peminjaman.bukti_url) + '" target="_blank" rel="noopener">Lihat berkas</a>'
                                : 'Belum ada berkas bukti.'
                        );
                        modal.show();
                    })
                    .fail(function () {
                        showAlert('Data peminjaman tidak ditemukan.', 'danger');
                    });
            });

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                clearErrors();

                const data = new FormData(form);
                const button = document.getElementById('btnSimpan');
                button.disabled = true;

                if (editingId) {
                    data.append('_method', 'PUT');
                }

                const url = editingId ? urls.base + '/' + editingId : urls.store;

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                })
                    .done(function (response) {
                        modal.hide();
                        showAlert(response.message, 'success');
                        loadData();
                    })
                    .fail(function (xhr) {
                        if (xhr.status === 422) {
                            showErrors(xhr.responseJSON.errors || {});
                        } else {
                            showAlert('Terjadi kesalahan saat menyimpan data.', 'danger');
                        }
                    })
                    .always(function () {
                        button.disabled = false;
                    });
            });

            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id');

                confirmDelete('Data peminjaman ini akan dihapus.').then(function (confirmed) {
                    if (!confirmed) {
                        return;
                    }

                    $.ajax({
                        url: urls.base + '/' + id,
                        method: 'DELETE',
                    })
                        .done(function (response) {
                            showAlert(response.message, 'success');
                            loadData();
                        })
                        .fail(function () {
                            showAlert('Gagal menghapus data peminjaman.', 'danger');
                        });
                });
            });

            loadData();
        });
    </script>
@endpush
