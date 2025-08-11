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
        // Check if column doesn't exist before adding
        if (!Schema::hasColumn('formulir_sementara', 'nomor_pendaftaran')) {
            Schema::table('formulir_sementara', function (Blueprint $table) {
                $table->string('nomor_pendaftaran')->nullable()->after('nama_lengkap');
            });
        }

        if (!Schema::hasColumn('formulirs', 'nomor_pendaftaran')) {
            Schema::table('formulirs', function (Blueprint $table) {
                $table->string('nomor_pendaftaran')->nullable()->after('nama_lengkap');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formulir_sementara', function (Blueprint $table) {
            $table->dropColumn('nomor_pendaftaran');
        });

        Schema::table('formulirs', function (Blueprint $table) {
            $table->dropColumn('nomor_pendaftaran');
        });
    }
};
