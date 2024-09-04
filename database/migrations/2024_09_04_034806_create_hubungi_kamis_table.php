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
        Schema::create('bantuan_kemanusiaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul_permohonan');
            $table->text('deskripsi_permohonan');
            $table->enum('kategori_bantuan', ['bencana', 'sosial', 'kebutuhan_mendesak']);
            $table->string('lokasi_bantuan')->nullable();
            $table->decimal('target_donasi', 15, 2)->nullable();
            $table->decimal('donasi_terkumpul', 15, 2)->default(0);
            $table->boolean('status_donasi')->default(false);
            $table->enum('status_permohonan', ['dalam proses', 'selesai', 'ditolak'])->default('dalam proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hubungi_kamis');
    }
};
