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
        Schema::create('format_c', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bayi')->unsigned();
            $table->foreign('id_bayi')->references('id')->on('bayi')->onDelete('cascade')->onUpdate('cascade');
            $table->string('tahapan_ks')->nullable();
            $table->string('kelompok_dasawisma')->nullable();
            $table->float('ukuran_lila')->nullable();
            $table->integer('jumlah_anak_hidup')->nullable();
            $table->integer('jumlah_anak_meinggal')->nullable();
            $table->text('imunisasi')->nullable();
            $table->string('jenis_kontrasepsi')->nullable();
            $table->date('tanggal_penggantian')->nullable();
            $table->string('penggantian_jenis_kontrasepsi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_c');
    }
};
