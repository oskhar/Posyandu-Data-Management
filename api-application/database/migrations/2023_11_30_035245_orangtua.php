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
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ayah', 50)->nullable();
            $table->string('nama_ibu', 50);
            $table->string('nik_ayah')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('rt_rw', 10)->nullable();
            $table->text('tempat_tinggal')->nullable();
            $table->text('tahapan_ks')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->date('tanggal_meninggal_ibu')->nullable();
            $table->boolean('wus_pus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_tua');
    }
};
