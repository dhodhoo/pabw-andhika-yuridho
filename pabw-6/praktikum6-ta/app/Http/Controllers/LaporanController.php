<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'tinggi_genangan' => ['required', 'integer', 'min:0'],
            'tanggal_kejadian' => ['required', 'date'],
        ]);

        $laporan = Laporan::create($validated);

        return view('laporan.konfirmasi', compact('laporan'));
    }

    public function index()
    {
        $laporans = Laporan::latest()->get();

        return view('laporan.index', compact('laporans'));
    }
}
