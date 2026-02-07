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
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable(); // Pastikan ini ada
                $table->string('password');
                $table->string('telepon')->nullable(); // Kolom kustom Anda
                $table->text('alamat')->nullable(); // Kolom kustom Anda
                $table->enum('role', ['pelanggan', 'supplier', 'admin', 'kurir'])->default('pelanggan'); // Kolom kustom Anda
                $table->enum('status_akun', ['aktif', 'pending', 'nonaktif'])->default('pending'); // Kolom kustom Anda
                $table->rememberToken(); // Pastikan ini ada
                $table->timestamps();
            });

            // Migrasi untuk password_reset_tokens dan sessions biasanya ada secara default atau dibuat bersamaan.
            // Jika Anda sudah memiliki file terpisah untuk ini dan tidak ingin mengubahnya, Anda bisa melewatinya.
            // Namun, jika Anda menghapusnya di Langkah 2, tambahkan ini juga:
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });

            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('users');
            Schema::dropIfExists('password_reset_tokens');
            Schema::dropIfExists('sessions');
        }
    };
    