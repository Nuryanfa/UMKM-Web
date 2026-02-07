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
        $table->string('order_id')->nullable(); // atau 'kode_transaksi' jika ingin seragam
        $table->double('total_price')->nullable();
        $table->string('payment_status')->default('pending');
        $table->string('delivery_address')->nullable();
        $table->string('courier_name')->nullable();
        $table->double('shipping_cost')->nullable();
        $table->string('snap_token')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
