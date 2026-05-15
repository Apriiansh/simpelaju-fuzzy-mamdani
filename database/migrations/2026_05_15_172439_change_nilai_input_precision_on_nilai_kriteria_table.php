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
        Schema::table('nilai_kriteria', function (Blueprint $table) {
            $table->decimal('nilai_input', 15, 3)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_kriteria', function (Blueprint $table) {
            $table->decimal('nilai_input', 15, 2)->change();
        });
    }
};
