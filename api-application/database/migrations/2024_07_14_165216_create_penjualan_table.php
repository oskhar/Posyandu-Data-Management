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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("admin_id");
            $table->string("nama_produk")->unique();
            $table->text("deskripsi")->nullable();
            $table->integer("harga");
            $table->string("gambar");
            $table->boolean("sedang_dijual");
            $table->boolean("pin");
            $table->timestamps();

            $table->foreign("admin_id")->references("id")->on("admin")->onDelete("cascade");
        });
        Schema::create("tag", function (Blueprint $table) {
            $table->id();
            $table->string("nama_tag")->unique();
        });
        Schema::create("produk_tag", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("produk_id");
            $table->unsignedBigInteger("tag_id");

            $table->foreign("produk_id")->references("id")->on("produk")->onDelete("cascade");
            $table->foreign("tag_id")->references("id")->on("tag")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_tag');
        Schema::dropIfExists('produk');
        Schema::dropIfExists('tag');
    }
};
