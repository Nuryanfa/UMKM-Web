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
            Schema::create('transaksis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pelanggan yang melakukan transaksi
                $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
                $table->foreignId('pembayaran_id')->constrained('pembayarans')->onDelete('cascade');
                $table->foreignId('pengiriman_id')->constrained('pengirimen')->onDelete('cascade')->nullable(); // Nullable jika pengiriman belum diatur
                $table->foreignId('kurir_id')->nullable()->constrained('users')->onDelete('set null'); // Kurir yang mengantar (jika ada, dari tabel users)

                $table->string('kode_transaksi')->unique();
                $table->decimal('total_transaksi', 10, 2);
                $table->enum('status_transaksi', ['baru', 'diproses', 'selesai', 'dibatalkan'])->default('baru');
                
                // Details kurir (di-embed langsung di sini agar tidak perlu migrasi terpisah)
                $table->string('nama_kurir')->nullable();
                $table->string('nomor_telepon_kurir')->nullable();

                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('transaksis');
        }
    };
    