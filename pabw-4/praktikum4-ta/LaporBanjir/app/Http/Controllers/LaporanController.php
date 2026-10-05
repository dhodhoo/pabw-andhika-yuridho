<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Tampilkan form pelaporan banjir.
    public function create()
    {
        return view('laporan.create');
    }

    // Simpan data dari form ke tabel laporan, lalu tampilkan halaman konfirmasi.
    public function store(Request $request)
    {
        $laporan = Laporan::create([
            'nama_pelapor' => $request->input('nama_pelapor'),
            'lokasi' => $request->input('lokasi'),
            'tinggi_genangan' => $request->input('tinggi_genangan'),
            'tanggal_kejadian' => $request->input('tanggal_kejadian'),
        ]);

        return view('laporan.konfirmasi', ['laporan' => $laporan]);
    }

    // Daftar laporan diambil dari tabel laporan.
    public function index()
    {
        $laporans = Laporan::all();

        return view('laporan.index', ['laporans' => $laporans]);
    }
}
