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
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email_admin')->unique();
            $table->bigInteger('id_jabatan')->unsigned();
            $table->foreign('id_jabatan')->references('id')->on('jabatan')->onDelete('cascade')->onUpdate('cascade');
            $table->string('foto_profile')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('alamat')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('no_telp')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
