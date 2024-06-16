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
        Schema::create('perizinans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sektor_id')->constrained();
            $table->foreignId('perizinan_lifecycle_id')->constrained();
            $table->foreignId('perizinan_configuration_id')->constrained();
            $table->string('nama_perizinan');
            $table->text('template_rekomendasi')->nullable();
            $table->text('template_izin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinans');
    }
};
