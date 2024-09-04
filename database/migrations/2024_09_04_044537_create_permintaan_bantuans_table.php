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
        Schema::create('permintaan_bantuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul_permohonan');
            $table->text('deskripsi_permohonan');
            $table->string('nama_pasien');
            $table->text('alamat_pasien')->nullable();
            $table->string('kontak_pasien')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('status_permohonan', ['menunggu', 'dalam proses', 'selesai', 'ditolak'])->default('menunggu');
            $table->foreignId('relawan_id')->nullable()->constrained('relawans')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_bantuans');
    }
};
