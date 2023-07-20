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
        Schema::create('votings', function (Blueprint $table) {
            $table->id();
            $table->string('slug_id')->unique();
            $table->foreignId('announcement_id');
            $table->foreignId('category_id');
            $table->foreignId('user_id')->nullable();
            $table->string('nama_admin')->nullable();
            $table->string('judul_voting');
            $table->text('pesan_voting');
            $table->string('exam_design')->nullable();
            $table->integer('durasi_voting');
            $table->dateTime('tanggal_expired')->nullable();
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
        Schema::dropIfExists('votings');
    }
};
