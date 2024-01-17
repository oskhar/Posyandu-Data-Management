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
            $table->float('sangat_kurus')->unsigned();
            $table->float('kurus')->unsigned();
            $table->float('normal_kurus')->unsigned();
            $table->float('baik')->unsigned();
            $table->float('normal_gemuk')->unsigned();
            $table->float('gemuk')->unsigned();
            $table->float('sangat_gemuk')->unsigned();
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
