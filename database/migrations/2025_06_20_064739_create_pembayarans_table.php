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
            Schema::create('pembayarans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
                $table->string('metode_pembayaran');
                $table->decimal('jumlah_pembayaran', 10, 2);
                $table->enum('status_pembayaran', ['pending', 'sukses', 'gagal', 'refund'])->default('pending');
                $table->string('bukti_pembayaran')->nullable(); // Path ke gambar bukti pembayaran
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('pembayarans');
        }
    };
    