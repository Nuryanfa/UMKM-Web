<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Menambahkan kolom supplier_id setelah user_id
            // Memastikan tidak ada duplikasi kolom sebelum menambahkannya
            if (!Schema::hasColumn('transaksis', 'supplier_id')) {
                $table->foreignId('supplier_id')
                      ->nullable() // Atur ini ke false jika supplier_id selalu wajib ada
                      ->after('user_id') // Kolom ini akan ditempatkan setelah kolom 'user_id'
                      ->constrained('users') // Ini akan membuat foreign key ke tabel 'users'
                      ->onDelete('set null'); // Jika user (supplier) dihapus, supplier_id di transaksi jadi NULL
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Untuk rollback migrasi, drop foreign key dulu jika ada
            if (Schema::hasColumn('transaksis', 'supplier_id')) { // Tambahkan cek ini
                $table->dropForeign(['supplier_id']);
                // Lalu drop kolomnya
                $table->dropColumn('supplier_id');
            }
        });
    }
};
