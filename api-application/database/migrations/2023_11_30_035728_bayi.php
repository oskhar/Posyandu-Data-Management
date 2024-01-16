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
        Schema::create('bayi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_orang_tua')->unsigned();
            $table->foreign('id_orang_tua')->references('id')->on('orang_tua')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama', 50);
            $table->string('jenis_kelamin', 2)->nullable();
            $table->string('nik')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->float('berat_lahir')->nullable();
            $table->float('tinggi_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->date('tanggal_meninggal')->nullable();
            $table->boolean('imd')->nullable();
            $table->boolean('lulus_asi_eksklusif')->nullable();
            $table->text('pelayanan')->nullable();
            $table->text('hasil_penimbangan')->nullable();
            $table->boolean('memiliki_kms')->nullable();
            $table->boolean('memiliki_kia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bayi');
    }
};
