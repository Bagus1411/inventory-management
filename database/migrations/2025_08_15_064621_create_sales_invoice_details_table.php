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
        Schema::create('sales_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_invoice_id')->constrained()->onDelete('cascade'); // Relasi ke sales_invoices
            $table->foreignId('item_id')->constrained()->onDelete('cascade'); // Relasi ke items
            $table->unsignedInteger('quantity'); // Jumlah barang
            $table->decimal('price', 15, 2); // Harga per unit
            $table->decimal('discount_percent', 5, 2)->default(0); // Diskon dalam persen (%)
            $table->decimal('discount_rp', 15, 2)->default(0); // Diskon dalam rupiah
            $table->text('note')->nullable(); // Catatan tambahan
            $table->decimal('subtotal', 15, 2)->default(0); // Total per item setelah diskon
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_details');
    }
};
