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
        Schema::create('persyaratans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perizinan_id')->constrained();
            $table->string('nama_persyaratan');
            $table->string('deskripsi_persyaratan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persyaratans');
    }
};
