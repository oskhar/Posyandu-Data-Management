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
        Schema::create('format_b_list_pelayanan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_format_b')->unsigned();
            $table->foreign('id_format_b')->references('id')->on('format_b')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('id_list_pelayanan')->unsigned();
            $table->foreign('id_list_pelayanan')->references('id')->on('list_pelayanan')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_b_list_pelayanan');
    }
};