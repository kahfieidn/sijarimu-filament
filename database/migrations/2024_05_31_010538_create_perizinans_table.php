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
            $table->boolean('is_template_rekomendasi')->default(false);
            $table->boolean('is_template_izin')->default(false);
            $table->text('template_rekomendasi')->nullable();
            $table->text('template_izin')->nullable();
            $table->boolean('is_save_as_template_rekomendasi')->default(false);
            $table->boolean('is_save_as_template_izin')->default(false);
            $table->boolean('is_active')->default(true);
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
