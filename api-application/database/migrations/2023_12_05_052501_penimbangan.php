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
        Schema::create('penimbangan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bayi')->unsigned()->nullable();
            $table->foreign('id_bayi')->references('id')->on('bayi')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('tahun_penimbangan');
            $table->integer('bulan_penimbangan');
            $table->float('berat_badan')->nullable();
            $table->string('ntob')->nullable();
            $table->string('asi_eksklusif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penimbangan');
    }
};
