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
            Schema::create('laporan_transaksis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
                $table->string('jenis_laporan'); // Contoh: 'harian', 'bulanan', 'tahunan'
                $table->decimal('pendapatan_bersih', 10, 2);
                $table->decimal('biaya_operasional', 10, 2)->default(0);
                $table->text('catatan_laporan')->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('laporan_transaksis');
        }
    };
    