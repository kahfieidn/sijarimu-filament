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
        Schema::create('status_permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('general_status');
            $table->string('nama_status');
            $table->string('icon');
            $table->string('color');
            $table->json('role_id')->constrained('roles')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_permohonans');
    }
};
