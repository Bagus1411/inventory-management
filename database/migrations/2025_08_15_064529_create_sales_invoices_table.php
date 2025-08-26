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
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique(); // Nomor invoice
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // Nama customer
            $table->date('date'); // Tanggal penjualan
            $table->text('description')->nullable(); // Deskripsi tambahan
            $table->decimal('discount_global', 15, 2)->default(0); // Diskon global (Rp)
            $table->decimal('ppn', 15, 2)->default(0); // Pajak PPN
            $table->decimal('total', 15, 2)->default(0); // Total sebelum diskon global & PPN
            $table->decimal('grand_total', 15, 2)->default(0); // Total akhir setelah diskon global & PPN
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoices');
    }
};
