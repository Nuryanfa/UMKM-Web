<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk; // Pastikan mengimpor model Produk
use App\Models\User;   // Pastikan mengimpor model User untuk mendapatkan supplier_id

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hapus semua produk yang ada sebelumnya untuk memastikan hanya produk yang diinginkan yang ada
        Produk::query()->delete(); // Lebih aman dari truncate


        // Cari user dengan role 'supplier' untuk mengaitkan produk.
        // Asumsi: ada setidaknya satu user dengan role 'supplier'.
        $supplier = User::where('role', 'supplier')->first();

        // Jika tidak ada supplier, Anda mungkin ingin membuat satu terlebih dahulu
        if (!$supplier) {
            $supplier = User::factory()->create([
                'name' => 'Supplier Test',
                'email' => 'supplier@example.com',
                'password' => bcrypt('password'),
                'role' => 'supplier',
                'status_akun' => 'active'
            ]);
        }

        // Buat produk dummy (hanya 3 yang diinginkan)
        Produk::create([
            'supplier_id' => $supplier->id,
            'nama_produk' => 'Bayam Segar',
            'deskripsi' => 'Bayam segar langsung dari petani lokal. Penuh nutrisi dan siap diolah.',
            'harga' => 8000,
            'stok' => 30,
            'kategori' => 'Sayuran Daun',
            'satuan' => 'ikat',
            'gambar_produk' => 'image/bayam3.jpg', // Contoh path gambar dummy
        ]);

        Produk::create([
            'supplier_id' => $supplier->id,
            'nama_produk' => 'Kangkung Organik',
            'deskripsi' => 'Kangkung pilihan dari kebun organik. Cocok untuk tumisan.',
            'harga' => 7500,
            'stok' => 25,
            'kategori' => 'Sayuran Daun',
            'satuan' => 'ikat',
            'gambar_produk' => 'image/kangkung01.jpg', // Contoh path gambar dummy
        ]);

        Produk::create([
            'supplier_id' => $supplier->id,
            'nama_produk' => 'Tomat Merah',
            'deskripsi' => 'Tomat merah segar, cocok untuk salad atau masakan. Penuh vitamin C.',
            'harga' => 12000,
            'stok' => 40,
            'kategori' => 'Sayuran Buah',
            'satuan' => 'kg',
            'gambar_produk' => 'image/tomat.jpg', // Contoh path gambar dummy
        ]);

        // Anda bisa menambahkan produk lain di sini jika perlu di masa depan
    }
}
