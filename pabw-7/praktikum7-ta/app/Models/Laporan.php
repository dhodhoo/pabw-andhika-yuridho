<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    public const STATUS = ['Menunggu', 'Di proses', 'Selesai'];

    protected $fillable = [
        'nama_pelapor',
        'no_hp',
        'lokasi',
        'kecamatan',
        'tinggi_air',
        'keterangan',
        'foto',
        'status',
    ];

    public function badgeColor(): string
    {
        return match ($this->status) {
            'Di proses' => '#b45309',
            'Selesai' => '#15803d',
            default => '#b91c1c',
        };
    }
}
