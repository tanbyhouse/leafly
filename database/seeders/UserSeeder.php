<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin Leafly',
            'email' => 'admin@leafly.com',
            'password' => Hash::make('admin123'),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // KARYAWAN
        $karyawanId = DB::table('users')->insertGetId([
            'name' => 'Budi Santoso',
            'email' => 'karyawan@leafly.com',
            'password' => Hash::make('karyawan123'),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // PELANGGAN
        $pelangganId = DB::table('users')->insertGetId([
            'name' => 'Siti Aminah',
            'email' => 'pelanggan@leafly.com',
            'password' => Hash::make('pelanggan123'),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ROLE MAPPING
        DB::table('user_roles')->insert([
            ['user_id' => $adminId, 'role_id' => 1],
            ['user_id' => $karyawanId, 'role_id' => 2],
            ['user_id' => $pelangganId, 'role_id' => 3],
        ]);
    }
}
