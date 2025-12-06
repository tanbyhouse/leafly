<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\FotoProduk;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== USER & ROLES ====================

        // Admin
        $adminUser = User::create([
            'email' => 'admin@leafly.com',
            'password' => Hash::make('admin123'),
            'tipe_user' => 'admin',
            'aktif' => true,
        ]);

        Admin::create([
            'user_id' => $adminUser->id,
            'nama' => 'Admin Leafly',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Raya Surabaya No. 123',
        ]);

        // Karyawan
        $karyawanUser = User::create([
            'email' => 'karyawan@leafly.com',
            'password' => Hash::make('karyawan123'),
            'tipe_user' => 'karyawan',
            'aktif' => true,
        ]);

        Karyawan::create([
            'user_id' => $karyawanUser->id,
            'kode_karyawan' => 'KRY001',
            'nama' => 'Budi Santoso',
            'telepon' => '081234567891',
            'alamat' => 'Jl. Diponegoro No. 45',
            'tanggal_bergabung' => now(),
            'status' => 'aktif',
        ]);

        // Pelanggan
        $pelangganUser = User::create([
            'email' => 'pelanggan@leafly.com',
            'password' => Hash::make('pelanggan123'),
            'tipe_user' => 'pelanggan',
            'aktif' => true,
        ]);

        Pelanggan::create([
            'user_id' => $pelangganUser->id,
            'nama' => 'Siti Aminah',
            'telepon' => '081234567892',
            'tanggal_lahir' => '1995-05-15',
            'jenis_kelamin' => 'P',
        ]);

        // ==================== WILAYAH ====================

        $provinsi = Provinsi::create([
            'kode_provinsi' => '35',
            'nama_provinsi' => 'Jawa Timur',
        ]);

        $kota = Kota::create([
            'provinsi_id' => $provinsi->id,
            'kode_kota' => '3578',
            'nama_kota' => 'Surabaya',
            'tipe' => 'Kota',
        ]);

        Kecamatan::create([
            'kota_id' => $kota->id,
            'kode_kecamatan' => '357801',
            'nama_kecamatan' => 'Gubeng',
        ]);

        Kecamatan::create([
            'kota_id' => $kota->id,
            'kode_kecamatan' => '357802',
            'nama_kecamatan' => 'Tegalsari',
        ]);

        // ==================== KATEGORI ====================

        $kategoriSayuran = Kategori::create([
            'nama_kategori' => 'Benih Sayuran',
            'deskripsi' => 'Benih sayuran berkualitas untuk kebun Anda',
        ]);

        $kategoriBuah = Kategori::create([
            'nama_kategori' => 'Bibit Buah',
            'deskripsi' => 'Bibit buah unggul siap tanam',
        ]);

        $kategoriAlat = Kategori::create([
            'nama_kategori' => 'Alat Berkebun',
            'deskripsi' => 'Perlengkapan berkebun berkualitas',
        ]);

        // ==================== PRODUK ====================

        // Produk 1: Benih Tomat
        $produkTomat = Produk::create([
            'kategori_id' => $kategoriSayuran->id,
            'kode_produk' => 'BNH-001',
            'nama_produk' => 'Benih Tomat Cherry',
            'deskripsi' => 'Benih tomat cherry berkualitas tinggi, cocok untuk pot atau lahan',
            'jenis_produk' => 'benih',
            'harga' => 15000,
            'stok' => 100,
            'berat' => 50,
            'is_aktif' => true,
        ]);

        FotoProduk::create([
            'produk_id' => $produkTomat->id,
            'path_foto' => 'products/tomat-cherry.jpg',
            'foto_utama' => true,
        ]);

        // Produk 2: Bibit Cabai
        $produkCabai = Produk::create([
            'kategori_id' => $kategoriSayuran->id,
            'kode_produk' => 'BBT-002',
            'nama_produk' => 'Bibit Cabai Rawit',
            'deskripsi' => 'Bibit cabai rawit super pedas, tinggi 15-20cm',
            'jenis_produk' => 'bibit',
            'harga' => 8000,
            'stok' => 50,
            'berat' => 200,
            'is_aktif' => true,
        ]);

        FotoProduk::create([
            'produk_id' => $produkCabai->id,
            'path_foto' => 'products/cabai-rawit.jpg',
            'foto_utama' => true,
        ]);

        // Produk 3: Sekop Mini
        $produkSekop = Produk::create([
            'kategori_id' => $kategoriAlat->id,
            'kode_produk' => 'ALT-003',
            'nama_produk' => 'Sekop Mini Stainless',
            'deskripsi' => 'Sekop mini dari bahan stainless steel, tahan karat',
            'jenis_produk' => 'alat',
            'harga' => 25000,
            'stok' => 30,
            'berat' => 300,
            'is_aktif' => true,
        ]);

        FotoProduk::create([
            'produk_id' => $produkSekop->id,
            'path_foto' => 'products/sekop-mini.jpg',
            'foto_utama' => true,
        ]);

        // Produk 4: Bibit Mangga
        $produkMangga = Produk::create([
            'kategori_id' => $kategoriBuah->id,
            'kode_produk' => 'BBT-004',
            'nama_produk' => 'Bibit Mangga Gedong',
            'deskripsi' => 'Bibit mangga gedong gincu, tinggi 60-80cm',
            'jenis_produk' => 'bibit',
            'harga' => 45000,
            'stok' => 20,
            'berat' => 1000,
            'is_aktif' => true,
        ]);

        FotoProduk::create([
            'produk_id' => $produkMangga->id,
            'path_foto' => 'products/mangga-gedong.jpg',
            'foto_utama' => true,
        ]);

        // Produk 5: Benih Sawi
        $produkSawi = Produk::create([
            'kategori_id' => $kategoriSayuran->id,
            'kode_produk' => 'BNH-005',
            'nama_produk' => 'Benih Sawi Hijau',
            'deskripsi' => 'Benih sawi hijau cepat panen, cocok hidroponik',
            'jenis_produk' => 'benih',
            'harga' => 10000,
            'stok' => 80,
            'berat' => 30,
            'is_aktif' => true,
        ]);

        FotoProduk::create([
            'produk_id' => $produkSawi->id,
            'path_foto' => 'products/sawi-hijau.jpg',
            'foto_utama' => true,
        ]);

        echo "\n✅ Seeder berhasil dijalankan!\n";
        echo "==========================================\n";
        echo "LOGIN CREDENTIALS:\n";
        echo "==========================================\n";
        echo "Admin:\n";
        echo "  Email: admin@leafly.com\n";
        echo "  Password: admin123\n\n";
        echo "Karyawan:\n";
        echo "  Email: karyawan@leafly.com\n";
        echo "  Password: karyawan123\n\n";
        echo "Pelanggan:\n";
        echo "  Email: pelanggan@leafly.com\n";
        echo "  Password: pelanggan123\n";
        echo "==========================================\n";
    }
}
