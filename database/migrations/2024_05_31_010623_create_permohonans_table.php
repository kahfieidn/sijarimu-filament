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
            $table->text('catatan_kesimpulan')->nullable();
            $table->text('message_bo')->nullable();
            $table->json('formulir');
            $table->json('berkas');
            $table->string('nomor_rekomendasi')->nullable();
            $table->string('nomor_kajian_teknis')->nullable();
            $table->string('nomor_izin')->nullable();
            $table->date('tanggal_rekomendasi_terbit')->nullable();
            $table->date('tanggal_kajian_teknis_terbit')->nullable();
            $table->date('tanggal_izin_terbit')->nullable();
            $table->string('rekomendasi_terbit')->nullable();
            $table->string('kajian_teknis')->nullable();
            $table->string('izin_terbit')->nullable();
            $table->json('activity_log')->nullable();
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
