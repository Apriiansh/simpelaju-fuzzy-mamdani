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
        Schema::create('rumah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
            
            // PILAR A: Keselamatan Bangunan
            $table->string('pondasi')->default('Tidak Ada'); // Ada, Tidak Ada
            $table->string('kolom_balok')->default('Rusak Berat'); // Rusak Berat, Rusak Sedang, Rusak Ringan
            $table->string('konstruksi_atap')->default('Rusak Berat'); // Rusak Berat, Rusak Sedang, Rusak Ringan
            
            // PILAR B: Kesehatan Penghuni
            $table->string('jendela')->default('Tidak Ada'); // Ada, Tidak Ada
            $table->string('ventilasi')->default('Tidak Ada'); // Ada, Tidak Ada
            $table->string('kamar_mandi')->default('Tidak Ada'); // Sendiri, Bersama, Tidak Ada
            $table->string('jarak_sumber_air')->default('Kurang dari 10 meter'); // Kurang dari 10 meter, Lebih dari 10 meter
            
            // PILAR C: Kepadatan Hunian
            $table->decimal('luas_bangunan', 10, 2); // dalam m2
            
            // PILAR D: Komponen Bangunan (Material & Kondisi)
            $table->string('material_atap')->default('Daun / Rumbia / Ijuk'); 
            $table->string('kondisi_atap')->default('Rusak Berat / Seluruhnya');
            
            $table->string('material_dinding')->default('Bambu / Anyaman');
            $table->string('kondisi_dinding')->default('Rusak Berat / Seluruhnya');
            
            $table->string('material_lantai')->default('Tanah');
            $table->string('kondisi_lantai')->default('Rusak Berat / Seluruhnya');
            
            // Data Pendukung
            $table->string('status_kepemilikan')->nullable(); // Milik Sendiri, Sewa, Menumpang
            $table->string('foto_rumah')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah');
    }
};
