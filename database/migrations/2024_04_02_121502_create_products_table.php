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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('product_name');
            $table->string('product_stock');
            $table->enum('product_type', ['satuan', 'kilo', 'liter']);
            $table->string('product_price');
            $table->foreignUuid('id_category')->references('id')->on('product_categories');
            $table->string('product_description');
            $table->string('thumbnail');
            $table->string('is_vendor');
            $table->string('vendor_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
