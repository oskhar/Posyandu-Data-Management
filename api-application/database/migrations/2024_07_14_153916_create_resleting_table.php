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
        Schema::create("user", function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("email")->unique();
            $table->string("password");
            $table->integer("poin");
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create("tantangan", function (Blueprint $table) {
            $table->id();
            $table->string("judul");
            $table->string("gambar")->nullable();
            $table->text("deskripsi");
            $table->date("tanggal_mulai");
            $table->date("tanggal_selesai");
            $table->timestamps();
        });
        Schema::create("submission", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("tantangan_id");
            $table->unsignedBigInteger("user_id");
            $table->text("file")->nullable();
            $table->string("link")->nullable();
            $table->enum("status", ["Tersubmit", "Sedang Diperiksa", "Sudah Dinilai"])->default("Tersubmit");
            $table->timestamps();

            $table->foreign("tantangan_id")->references("id")->on("tantangan")->onDelete("cascade");
            $table->foreign("user_id")->references("id")->on("user")->onDelete("cascade");
        });
        Schema::create("penilaian", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("submission_id");
            $table->unsignedBigInteger("admin_id");
            $table->text("feedback")->nullable();
            $table->integer("peringkat");
            $table->timestamps();

            $table->foreign("submission_id")->references("id")->on("submission")->onDelete("cascade");
            $table->foreign("admin_id")->references("id")->on("admin")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
        Schema::dropIfExists('submission');
        Schema::dropIfExists('tantangan');
        Schema::dropIfExists('user');
    }
};
