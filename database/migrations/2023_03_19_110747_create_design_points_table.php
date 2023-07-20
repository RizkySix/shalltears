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
        Schema::create('design_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('selling_produk_id');
            $table->decimal('point_request');
            $table->string('nama_rekening');
            $table->string('no_rekening');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('design_points');
    }
};
