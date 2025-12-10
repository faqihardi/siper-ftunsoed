<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_user' => 'Admin Bapendik',
            'no_induk' => '197106281999031001 ',
            'email' => 'admin@unsoed.ac.id',
            'password' => bcrypt('password'),
            'no_hp' => '0812345678',
            'role_id' => 2
        ]);

        User::create([
            'nama_user' => 'Wakil Dekan II',
            'no_induk' => '196901111991031004',
            'email' => 'wadek2@unsoed.ac.id',
            'password' => bcrypt('password'),
            'no_hp' => '0811112222',
            'role_id' => 3
        ]);

        User::create([
            'nama_user' => 'Sub Koor Umum dan Keuangan',
            'no_induk' => '196507051993031003',
            'email' => 'subkoor@unsoed.ac.id',
            'password' => bcrypt('password'),
            'no_hp' => '0888999777',
            'role_id' => 4
        ]);
    }
}
