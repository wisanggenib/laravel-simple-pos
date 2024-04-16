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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->foreignUuid('id_user')->references('id')->on('users');
            $table->enum('status', ['order', 'proses', 'kirim', 'selesai', 'tolak']);
            $table->string('bukti_po')->nullable();
            $table->string('tgl_proses')->nullable();
            $table->string('resi')->nullable();
            $table->string('tgl_kirim')->nullable();
            $table->string('bukti_terima')->nullable();
            $table->string('tgl_diterima')->nullable();
            $table->string('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
