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
        Schema::create('batas_tab', function (Blueprint $table) {
            $table->bigInteger('nomor')->unsigned()->primary();
            $table->integer('awal')->unsigned();
            $table->integer('akhir')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batas_tab');
    }
};
