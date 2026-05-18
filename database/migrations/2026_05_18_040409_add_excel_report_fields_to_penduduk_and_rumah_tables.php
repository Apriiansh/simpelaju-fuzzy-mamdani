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
        // Alter tabel penduduk
        Schema::table('penduduk', function (Blueprint $table) {
            $table->string('rt', 10)->nullable()->after('alamat');
            $table->string('rw', 10)->nullable()->after('rt');
            $table->integer('usia')->nullable()->after('rw');
            $table->string('pendidikan_terakhir', 50)->nullable()->after('usia');
            $table->char('jenis_kelamin', 1)->nullable()->after('pendidikan_terakhir'); // 'L' atau 'P'
            $table->string('pekerjaan_utama', 100)->nullable()->after('jenis_kelamin');
            $table->boolean('pernah_dapat_bantuan')->default(false)->after('jumlah_tanggungan');
            $table->string('jenis_kawasan', 100)->nullable()->after('pernah_dapat_bantuan');
            $table->boolean('aset_rumah_lain')->default(false)->after('jenis_kawasan');
            $table->boolean('aset_tanah_lain')->default(false)->after('aset_rumah_lain');
        });

        // Alter tabel rumah
        Schema::table('rumah', function (Blueprint $table) {
            $table->string('nomor_sertifikat', 255)->nullable()->after('status_kepemilikan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rumah', function (Blueprint $table) {
            $table->dropColumn(['nomor_sertifikat']);
        });

        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn([
                'rt',
                'rw',
                'usia',
                'pendidikan_terakhir',
                'jenis_kelamin',
                'pekerjaan_utama',
                'pernah_dapat_bantuan',
                'jenis_kawasan',
                'aset_rumah_lain',
                'aset_tanah_lain'
            ]);
        });
    }
};
