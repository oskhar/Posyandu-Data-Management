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
        Schema::create('standar_deviasi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_berat_untuk_umur')->unsigned();
            $table->foreign('id_berat_untuk_umur')->references('id')->on('berat_untuk_umur')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('umur_bulan');
            $table->float('sangat_kurus');
            $table->float('kurus');
            $table->float('normal_kurus');
            $table->float('baik');
            $table->float('normal_gemuk');
            $table->float('gemuk');
            $table->float('sangat_gemuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar_deviasi');
    }
};
