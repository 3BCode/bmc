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
        Schema::create('ambulans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('permintaan_bantuan_id')->nullable()->constrained('permintaan_bantuans')->onDelete('set null');
            $table->string('no_plat');
            $table->string('keterangan_mobil');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambulans');
    }
};
