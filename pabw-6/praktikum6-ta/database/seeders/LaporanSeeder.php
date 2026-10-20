<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $lokasi = [
            'Dayeuhkolot',
            'Baleendah',
            'Bojongsoang',
            'Margaasih',
            'Cileunyi',
        ];

        for ($i = 0; $i < 20; $i++) {
            DB::table('laporan')->insert([
                'nama_pelapor' => $faker->name,
                'lokasi' => $faker->randomElement($lokasi),
                'tinggi_genangan' => $faker->numberBetween(10, 120),
                'tanggal_kejadian' => $faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
