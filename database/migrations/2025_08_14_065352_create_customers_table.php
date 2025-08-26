<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Primary Key (bigint auto increment)

            $table->string('code', 20)->unique();
            // Kode unik pelanggan, misalnya "CUST0001"

            $table->string('name', 100);
            // Nama lengkap pelanggan

            $table->string('email', 100)->unique();
            // Email, boleh null, unik jika diisi

            $table->string('phone', 20)->nullable();
            // Nomor telepon

            $table->text('address')->nullable();
            // Alamat lengkap

            $table->string('city', 50)->nullable();
            // Kota pelanggan

            $table->string('province', 50)->nullable();
            // Provinsi

            $table->string('postal_code', 10)->nullable();
            // Kode pos

            $table->boolean('status')->default(1);
            // Status pelanggan

            $table->timestamps();
            // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
