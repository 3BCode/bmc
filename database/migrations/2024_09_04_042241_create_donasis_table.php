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
        Schema::create('donasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bantuan_kemanusiaan_id')->constrained('bantuan_kemanusiaans')->onDelete('cascade');
            $table->decimal('jumlah_donasi', 15, 2);
            $table->string('metode_pembayaran')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_order_id')->nullable();
            $table->enum('status_pembayaran', ['pending', 'berhasil', 'gagal', 'expired'])->default('pending');
            $table->text('response_midtrans')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasis');
    }
};
