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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->foreignUuid('id_area')->references('id')->on('areas');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('fullname')->unique();
            $table->enum('role', ['superadmin', 'admin', 'member']);
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
