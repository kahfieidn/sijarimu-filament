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
        Schema::create('profile_usahas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('npwp');
            $table->string('npwp_file');
            $table->string('nib');
            $table->string('nib_file');
            $table->text('alamat');
            $table->string('provinsi');
            $table->string('domisili');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_usahas');
    }
};
