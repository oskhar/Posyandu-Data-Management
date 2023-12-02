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
        Schema::create('format_a', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bayi')->unsigned();
            $table->foreign('id_bayi')->references('id')->on('bayi')->onDelete('cascade')->onUpdate('cascade');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_a');
    }
};
