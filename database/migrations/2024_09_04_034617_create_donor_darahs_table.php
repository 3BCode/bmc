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
        Schema::create('donor_darahs', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kegiatan');
            $table->text('deskripsi_kegiatan')->nullable();
            $table->string('lokasi_kegiatan');
            $table->date('tanggal_kegiatan');
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->integer('jumlah_pendaftar')->default(0);
            $table->integer('kebutuhan_darah')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->boolean('notifikasi_pengingat')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donor_darahs');
    }
};
