<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $kecamatan = [
            'Dayeuhkolot',
            'Baleendah',
            'Bojongsoang',
            'Rancaekek',
            'Majalaya',
        ];

        for ($i = 0; $i < 20; $i++) {
            $tanggal = $faker->dateTimeBetween('-1 month', 'now');

            DB::table('laporan')->insert([
                'nama_pelapor' => $faker->name,
                'lokasi' => $faker->randomElement($kecamatan),
                'tinggi_genangan' => $faker->numberBetween(10, 150),
                'tanggal_kejadian' => $tanggal->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
