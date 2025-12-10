<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $ruangs = [
            [
                'nama_ruang' => 'A201',
                'kapasitas' => 50,
                'tipe_ruang' => 'Kelas',
                'gedung_id' => 1, 
            ],
            [
                'nama_ruang' => 'A202',
                'kapasitas' => 50,
                'tipe_ruang' => 'Kelas',
                'gedung_id' => 1,
            ],
            [
                'nama_ruang' => 'A203',
                'kapasitas' => 50,
                'tipe_ruang' => 'Kelas',
                'gedung_id' => 1,
            ],
            [
                'nama_ruang' => 'A204',
                'kapasitas' => 50,
                'tipe_ruang' => 'Kelas',
                'gedung_id' => 1,
            ],
            [
                'nama_ruang' => 'A205',
                'kapasitas' => 50,
                'tipe_ruang' => 'Kelas',
                'gedung_id' => 1,
            ],
        ];

        Ruangan::insert($ruangs);
    }
}
