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
        Schema::table('penilaian', function (Blueprint $table) {
            $table->enum('verifikasi_status', ['draft', 'dikirim', 'dikembalikan', 'terverifikasi', 'valid'])
                  ->default('draft')
                  ->after('status');
            $table->text('catatan_revisi')->nullable()->after('verifikasi_status');
            $table->timestamp('tanggal_validasi')->nullable()->after('catatan_revisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->dropColumn(['verifikasi_status', 'catatan_revisi', 'tanggal_validasi']);
        });
    }
};
