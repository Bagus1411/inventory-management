<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    protected $guarded = ['id'];


    public function up(): void
    {
        Schema::create('incoming_transaction_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->foreignId('incoming_transaction_id');
            $table->unsignedInteger('quantity');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_transaction_detail');
    }
};
