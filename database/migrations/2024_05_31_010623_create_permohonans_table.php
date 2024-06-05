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
        Schema::create('permohonans', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('perizinan_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('status_permohonan_id')->constrained();
            $table->foreignId('profile_usaha_id')->nullable();
            $table->text('message')->nullable();
            $table->json('formulir');
            $table->json('berkas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
