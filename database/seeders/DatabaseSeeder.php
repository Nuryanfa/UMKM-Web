<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Produk; // Pastikan Produk Model di-import jika ProdukSeeder dipanggil

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seed database aplikasi.
     */
    public function run(): void
    {
        // 1. Buat user Admin (untuk Anda sendiri)
        User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@umkm.com', // Email khusus untuk admin
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'), // Password khusus admin
            'telepon' => '081122334455',
            'alamat' => 'Jl. Admin Utama No. 1, Jakarta',
            'role' => 'admin',
            'status_akun' => 'aktif',
        ]);

        // 2. Buat user Supplier
        User::factory()->create([
            'name' => 'Supplier Toko Jaya',
            'email' => 'supplier@umkm.com', // Email khusus supplier
            'email_verified_at' => now(),
            'password' => bcrypt('supplier123'), // Password khusus supplier
            'telepon' => '082233445566',
            'alamat' => 'Jl. Produksi No. 10, Bandung',
            'role' => 'supplier',
            'status_akun' => 'aktif',
        ]);

        // 3. Buat user Pelanggan
        User::factory()->create([
            'name' => 'Pelanggan Setia',
            'email' => 'pelanggan@umkm.com', // Email khusus pelanggan
            'email_verified_at' => now(),
            'password' => bcrypt('pelanggan123'), // Password khusus pelanggan
            'telepon' => '083344556677',
            'alamat' => 'Jl. Konsumen No. 20, Surabaya',
            'role' => 'pelanggan',
            'status_akun' => 'aktif',
        ]);

        // Panggil ProdukSeeder setelah user dibuat
        $this->call(ProdukSeeder::class);

        // Anda bisa menambahkan pemanggilan seeder lain di sini jika ada:
        // $this->call([
        //     PesananSeeder::class,
        //     PembayaranSeeder::class,
        // ]);
    }
}
