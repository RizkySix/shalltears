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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('slug_id')->unique();
            $table->foreignId('category_id');
            $table->foreignId('user_id')->nullable();
            $table->string('judul');
            $table->string('nama_admin')->nullable();
            $table->text('pesan');
            $table->string('exam_design')->nullable();
            $table->integer('durasi');
            $table->dateTime('tanggal_expired')->nullable();
            $table->boolean('publikasi_voting')->default(false);
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
        Schema::dropIfExists('announcements');
    }
};
