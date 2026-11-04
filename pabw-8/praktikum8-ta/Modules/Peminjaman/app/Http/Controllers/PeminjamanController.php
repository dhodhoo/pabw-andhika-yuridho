<?php

namespace Modules\Peminjaman\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Modules\Peminjaman\Http\Requests\StorePeminjamanRequest;
use Modules\Peminjaman\Http\Requests\UpdatePeminjamanRequest;
use Modules\Peminjaman\Models\Peminjaman;

class PeminjamanController extends Controller
{
    /**
     * Show the AJAX page.
     */
    public function index(): View
    {
        return view('peminjaman::index');
    }

    /**
     * Return all loans as JSON for the table.
     */
    public function data(): JsonResponse
    {
        $peminjamans = Peminjaman::query()->latest('id')->get()->map(fn (Peminjaman $peminjaman) => [
            'id' => $peminjaman->id,
            'nama_peminjam' => $peminjaman->nama_peminjam,
            'judul_buku' => $peminjaman->judul_buku,
            'tanggal_pinjam' => $peminjaman->tanggal_pinjam->format('Y-m-d'),
            'tanggal_kembali' => $peminjaman->tanggal_kembali->format('Y-m-d'),
            'status' => $peminjaman->status,
            'bukti_url' => $peminjaman->bukti ? Storage::disk('public')->url($peminjaman->bukti) : null,
        ]);

        return response()->json(['data' => $peminjamans]);
    }

    /**
     * Return one loan as JSON for the edit modal.
     */
    public function show(Peminjaman $peminjaman): JsonResponse
    {
        return response()->json([
            'id' => $peminjaman->id,
            'nama_peminjam' => $peminjaman->nama_peminjam,
            'judul_buku' => $peminjaman->judul_buku,
            'tanggal_pinjam' => $peminjaman->tanggal_pinjam->format('Y-m-d'),
            'tanggal_kembali' => $peminjaman->tanggal_kembali->format('Y-m-d'),
            'status' => $peminjaman->status,
            'bukti_url' => $peminjaman->bukti ? Storage::disk('public')->url($peminjaman->bukti) : null,
        ]);
    }

    /**
     * Store a new loan.
     */
    public function store(StorePeminjamanRequest $request): JsonResponse
    {
        $data = $request->safe()->except('bukti');

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('bukti_peminjaman', 'public');
        }

        $peminjaman = Peminjaman::create($data);

        return response()->json([
            'message' => 'Peminjaman berhasil ditambahkan.',
            'id' => $peminjaman->id,
        ], 201);
    }

    /**
     * Update the given loan.
     */
    public function update(UpdatePeminjamanRequest $request, Peminjaman $peminjaman): JsonResponse
    {
        $data = $request->safe()->except('bukti');

        if ($request->hasFile('bukti')) {
            if ($peminjaman->bukti) {
                Storage::disk('public')->delete($peminjaman->bukti);
            }

            $data['bukti'] = $request->file('bukti')->store('bukti_peminjaman', 'public');
        }

        $peminjaman->update($data);

        return response()->json(['message' => 'Peminjaman berhasil diperbarui.']);
    }

    /**
     * Remove the given loan and its uploaded file.
     */
    public function destroy(Peminjaman $peminjaman): JsonResponse
    {
        if ($peminjaman->bukti) {
            Storage::disk('public')->delete($peminjaman->bukti);
        }

        $peminjaman->delete();

        return response()->json(['message' => 'Peminjaman berhasil dihapus.']);
    }
}
