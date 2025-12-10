<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['role_id' => 1, 'nama_role' => 'peminjam'],
            ['role_id' => 2, 'nama_role' => 'admin_bapendik'],
            ['role_id' => 3, 'nama_role' => 'wakil_dekan_2'],
            ['role_id' => 4, 'nama_role' => 'sub_koor'],
        ]);
    }
}
