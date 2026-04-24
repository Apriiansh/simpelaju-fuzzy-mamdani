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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduk');
            $table->foreignId('user_id')->constrained('users');
            $table->string('periode'); // e.g., "2025-Q1"
            $table->dateTime('tanggal_penilaian')->useCurrent();
            $table->enum('status', ['DRAFT', 'DIPROSES', 'SELESAI'])->default('DRAFT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
