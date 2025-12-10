<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gedung;

class GedungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gedungs = [
            ['nama_gedung' => 'Gedung A'],
            ['nama_gedung' => 'Gedung C'],
            ['nama_gedung' => 'Gedung D/Laboratorium'],
            ['nama_gedung' => 'E'],
            ['nama_gedung' => 'F'],
            ['nama_gedung' => 'Aula F'],
            ['nama_gedung' => 'Lapangan Basket'],
            ['nama_gedung' => 'Majid Teknik'],
        ];

        Gedung::insert($gedungs);
    }
}
