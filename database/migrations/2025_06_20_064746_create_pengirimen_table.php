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
            Schema::create('pengirimen', function (Blueprint $table) {
                $table->id();
                $table->string('nomor_resi')->unique()->nullable();
                $table->enum('status_pengiriman', ['diproses', 'dikemas', 'dikirim', 'diterima', 'gagal'])->default('diproses');
                $table->string('alamat_tujuan');
                $table->string('kurir_ekspedisi')->nullable(); // Nama kurir (misal: JNE, J&T)
                $table->string('catatan_pengiriman')->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('pengirimen');
        }
    };
    