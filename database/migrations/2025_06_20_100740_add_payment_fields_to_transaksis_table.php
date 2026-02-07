<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('transaksis', function (Blueprint $table) {
        if (!Schema::hasColumn('transaksis', 'transaction_id')) {
            $table->string('transaction_id')->nullable();
        }

        if (!Schema::hasColumn('transaksis', 'payment_method')) {
            $table->string('payment_method')->nullable();
        }

        if (!Schema::hasColumn('transaksis', 'status_code')) {
            $table->string('status_code')->nullable();
        }

        if (!Schema::hasColumn('transaksis', 'raw_response')) {
            $table->longText('raw_response')->nullable();
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::table('transaksis', function (Blueprint $table) {
        $table->dropColumn(['transaction_id', 'payment_method', 'status_code', 'raw_response']);
    });
    }
};
