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
        Schema::create('posyandu', function (Blueprint $table) {
            $table->string('nama_posyandu', 50)->primary()->nullable();
            $table->string('kota', 30)->nullable();
            $table->string('kecamatan', 30)->nullable();
            $table->string('kelurahan', 30)->nullable();
            $table->string('rt_rw', 10)->nullable();
            $table->text('penyampaian_ketua')->nullable();
            $table->string('gambar_gedung', 100)->nullable();
            $table->string('gambar_struktur_organisasi', 100)->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandu');
    }
};
