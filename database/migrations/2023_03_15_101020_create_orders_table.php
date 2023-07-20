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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('selling_produk_id');
            $table->string('status');
            $table->string('jne_resi')->nullable();
            $table->string('transaction_status');
            $table->string('transaction_id');
            $table->string('order_id');
            $table->string('pemesan');
            $table->string('nama_produk');
            $table->string('warna');
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('size');
            $table->string('qty');
            $table->string('harga');
            $table->string('gross_amount');
            $table->string('payment_type');
            $table->string('payment_code')->nullable();
            $table->string('via_payment')->nullable();
            $table->string('pdf_url')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
