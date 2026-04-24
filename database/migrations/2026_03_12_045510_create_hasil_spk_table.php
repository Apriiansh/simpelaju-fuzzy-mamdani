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
        Schema::create('hasil_spk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_id')->unique()->constrained('penilaian')->onDelete('cascade');
            $table->decimal('nilai_defuzzifikasi', 15, 4);
            $table->enum('kategori_kelayakan', ['TIDAK_LAYAK', 'LAYAK']);
            $table->text('rekomendasi')->nullable();
            $table->json('detail_perhitungan')->nullable(); // Trace lengkap fuzzy
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_spk');
    }
};
