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
        Schema::table('school_classes', function (Blueprint $table) {
            // Drop the existing unique constraint on name
            $table->dropUnique(['name']);

            // Add a composite unique constraint on name and academic_year
            $table->unique(['name', 'academic_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_classes', function (Blueprint $table) {
            // Drop the composite unique constraint
            $table->dropUnique(['name', 'academic_year']);

            // Restore the original unique constraint on name only
            $table->unique('name');
        });
    }
};
