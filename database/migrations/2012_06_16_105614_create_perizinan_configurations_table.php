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
        Schema::create('perizinan_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('nama_configuration');
            $table->string('prefix_nomor_rekomendasi');
            $table->string('suffix_nomor_rekomendasi');
            $table->string('nomor_rekomendasi');
            $table->string('prefix_nomor_izin');
            $table->string('suffix_nomor_izin');
            $table->string('nomor_izin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinan_configurations');
    }
};
