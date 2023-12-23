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
            $table->string('nama_lengkap', 100);
            $table->string('email_admin', 70)->unique();
            $table->bigInteger('id_jabatan')->unsigned();
            $table->foreign('id_jabatan')->references('id')->on('jabatan')->onDelete('cascade')->onUpdate('cascade');
            $table->string('foto_profile', 70)->default('/images/upload/profileDefault.svg');
            $table->string('jenis_kelamin', 2)->nullable();
            $table->string('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
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
