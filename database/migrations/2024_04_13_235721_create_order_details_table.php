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
        Schema::create('order_details', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->foreignUuid('id_order')->references('id')->on('orders');
            $table->string('id_product');
            $table->string('product_name');
            $table->string('price');
            $table->string('quantity');
            $table->string('thumbnail');
            $table->string('bukti');
            $table->string('deskripsi');
            $table->enum('status', ['proses', 'terima', 'reject', 'ulang']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
