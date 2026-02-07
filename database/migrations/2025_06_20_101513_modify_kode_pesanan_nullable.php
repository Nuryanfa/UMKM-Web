<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('pesanans', function (Blueprint $table) {
        $table->string('kode_pesanan')->nullable()->change();
    });
}

public function down()
{
    Schema::table('pesanans', function (Blueprint $table) {
        $table->string('kode_pesanan')->nullable(false)->change();
    });
}

};
