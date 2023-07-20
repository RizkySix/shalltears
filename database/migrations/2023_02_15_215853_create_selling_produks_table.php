<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selling_produks', function (Blueprint $table) {
            $table->id();
            $table->string('slug_id')->unique();
            $table->foreignId('category_id');
            $table->foreignId('user_id')->nullable();
            $table->foreignId('diskon_id')->nullable();
            $table->integer('terjual')->default(0)->nullable();
            $table->string('user_point')->default(0)->nullable();
            $table->dateTime('durasi_point')->nullable();
            $table->boolean('status_expired')->nullable()->default(0);
            $table->string('nama_admin')->nullable();
            $table->string('nama_produk');
            $table->string('warna_produk');
            $table->string('harga_produk');
            $table->text('deskripsi_produk');
            $table->boolean('status_arsip')->default(false);
            $table->string('produk_image1');
            $table->string('produk_image2')->nullable();
            $table->string('produk_image3')->nullable();
            $table->string('produk_image4')->nullable();
            $table->string('produk_image5')->nullable();
            $table->string('produk_image6')->nullable();
            $table->string('produk_image7')->nullable();
            $table->string('produk_image8')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('selling_produks');
    }
};
