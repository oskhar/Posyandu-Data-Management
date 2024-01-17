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
            $table->bigInteger('id_orang_tua')->unsigned();
            $table->foreign('id_orang_tua')->references('id')->on('orang_tua')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('umur')->nullable()->unsigned();
            $table->string('tahapan_ks')->nullable();
            $table->string('kelompok_dasawisma')->nullable();
            $table->float('lila')->nullable()->unsigned();
            $table->integer('jumlah_anak_hidup')->nullable()->unsigned();
            $table->integer('jumlah_anak_meninggal')->nullable()->unsigned();
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
