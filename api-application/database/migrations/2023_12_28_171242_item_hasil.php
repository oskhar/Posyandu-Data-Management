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
        Schema::create('item_hasil', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_list_hasil')->unsigned();
            $table->foreign('id_list_hasil')->references('id')->on('list_hasil')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('nomor_batas_tab')->unsigned();
            $table->foreign('nomor_batas_tab')->references('nomor')->on('batas_tab')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_hasil');
    }
};
