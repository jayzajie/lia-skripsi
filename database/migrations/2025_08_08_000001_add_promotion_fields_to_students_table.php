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
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'is_repeating')) {
                $table->boolean('is_repeating')->default(false)->after('academic_year');
            }
            
            if (!Schema::hasColumn('students', 'promotion_status')) {
                $table->enum('promotion_status', ['pending', 'promoted', 'repeating', 'graduated'])
                      ->default('pending')
                      ->after('is_repeating');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'is_repeating')) {
                $table->dropColumn('is_repeating');
            }
            
            if (Schema::hasColumn('students', 'promotion_status')) {
                $table->dropColumn('promotion_status');
            }
        });
    }
};
