<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->unsignedBigInteger('pembayaran_id')->nullable()->change();
            $table->unsignedBigInteger('pengiriman_id')->nullable()->change();
            $table->unsignedBigInteger('kurir_id')->nullable()->change();
            $table->string('kode_transaksi')->nullable()->change();
            $table->decimal('total_transaksi', 15, 2)->nullable()->change();
            $table->string('status_transaksi')->nullable()->change();
            $table->string('nama_kurir')->nullable()->change();
            $table->string('nomor_telepon_kurir')->nullable()->change();
            $table->string('order_id')->nullable()->change();
            $table->decimal('total_price', 15, 2)->nullable()->change();
            $table->string('payment_status')->nullable()->change();
            $table->text('delivery_address')->nullable()->change();
            $table->string('courier_name')->nullable()->change();
            $table->decimal('shipping_cost', 10, 2)->nullable()->change();
            $table->string('snap_token')->nullable()->change();
        });
    }

    public function down(): void {
        // Optional: restore to NOT NULL if needed
    }
};
