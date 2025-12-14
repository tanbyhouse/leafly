<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'admin', 'description' => 'Pemilik Toko'],
            ['name' => 'karyawan', 'description' => 'Staff Operasional'],
            ['name' => 'pelanggan', 'description' => 'Pelanggan'],
        ]);
    }
}
