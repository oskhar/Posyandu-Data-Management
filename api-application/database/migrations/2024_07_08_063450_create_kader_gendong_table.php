<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('penanda_tangan');
            $table->date('tanggal_surat');
            $table->string('nomor_telepon', 15);
            $table->text('kalimat_pembuka')->nullable();
            $table->text('isi_surat')->nullable();
            $table->text('kalimat_penutup')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('cascade');
        });
        Schema::create('penugasan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('jabatan', 255);
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
        Schema::create('penugasan_surat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_id');
            $table->unsignedBigInteger('penugasan_id');
            $table->timestamps();

            $table->foreign('surat_id')->references('id')->on('surat')->onDelete('cascade');
            $table->foreign('penugasan_id')->references('id')->on('penugasan')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasan_surat');
        Schema::dropIfExists('penugasan');
        Schema::dropIfExists('surat');
    }
};
