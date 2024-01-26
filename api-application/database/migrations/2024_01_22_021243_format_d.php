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
        Schema::create('format_d', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_orang_tua')->unsigned();
            $table->foreign('id_orang_tua')->references('id')->on('orang_tua')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('umur')->nullable()->unsigned();
            $table->string('kelompok_dasawisma')->nullable();
            $table->date('tanggal_pendaftaran')->nullable();
            $table->integer('umur_kehamilan')->nullable()->unsigned();
            $table->integer('hamil_ke')->nullable()->unsigned();
            $table->float('lila')->nullable()->unsigned();
            $table->string('pmt_pemulihan')->nullable();
            $table->string('pil_tambah_darah')->nullable();
            $table->text('imunisasi')->nullable();
            $table->text('penimbangan')->nullable();
            $table->boolean('vit_a')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_d');
    }
};
