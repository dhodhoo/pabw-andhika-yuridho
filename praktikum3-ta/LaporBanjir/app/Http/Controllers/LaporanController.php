<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //Tampilkan form pelaporan banjir.
    public function create()
    {
        return view('laporan.create');
    }

    //Terima data form (POST) lalu tampilkan halaman konfirmasi.
    public function store(Request $request)
    {
        $laporan = [
            'nama_pelapor' => $request->nama_pelapor,
            'lokasi' => $request->lokasi,
            'tinggi_genangan' => $request->tinggi_genangan,
        ];

        return view('laporan.konfirmasi', compact('laporan'));
    }

    //Daftar laporan (data contoh, tanpa database).
    public function index()
    {
        $laporans = [
            [
                'nama_pelapor' => 'Andi Nugraha',
                'lokasi' => 'Kp. Cibiru, Cileunyi',
                'tinggi_genangan' => 25,
                'waktu' => '2026-09-26 08:15',
            ],
            [
                'nama_pelapor' => 'Siti Rahayu',
                'lokasi' => 'Jl. Soekarno-Hatta, Kiaracondong',
                'tinggi_genangan' => 30,
                'waktu' => '2026-09-27 09:30',
            ],
            [
                'nama_pelapor' => 'Dedi Kurniawan',
                'lokasi' => 'Desa Cimeyan, Cisarua',
                'tinggi_genangan' => 70,
                'waktu' => '2026-09-27 14:45',
            ],
            [
                'nama_pelapor' => 'Rina Marlina',
                'lokasi' => 'Kp. Sukamaju, Cimahi',
                'tinggi_genangan' => 85,
                'waktu' => '2026-09-28 07:05',
            ],
        ];

        return view('laporan.index', compact('laporans'));
    }
}
