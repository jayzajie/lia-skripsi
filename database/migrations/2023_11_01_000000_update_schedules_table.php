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
        // First check if the table exists
        if (Schema::hasTable('schedules')) {
            Schema::table('schedules', function (Blueprint $table) {
                // Check if columns already exist before adding
                if (!Schema::hasColumn('schedules', 'day_of_week') && Schema::hasColumn('schedules', 'day')) {
                    // Rename day to day_of_week
                    $table->renameColumn('day', 'day_of_week');
                } else if (!Schema::hasColumn('schedules', 'day_of_week')) {
                    // Add day_of_week if it doesn't exist
                    $table->string('day_of_week')->after('teacher_id');
                }

                if (!Schema::hasColumn('schedules', 'class_level') && Schema::hasColumn('schedules', 'class')) {
                    // Rename class to class_level
                    $table->renameColumn('class', 'class_level');
                } else if (!Schema::hasColumn('schedules', 'class_level')) {
                    // Add class_level if it doesn't exist
                    $table->string('class_level')->after('end_time');
                }

                if (!Schema::hasColumn('schedules', 'academic_year')) {
                    $table->string('academic_year')->after('room');
                }

                if (!Schema::hasColumn('schedules', 'semester')) {
                    $table->string('semester')->after('academic_year');
                }

                if (!Schema::hasColumn('schedules', 'status') && Schema::hasColumn('schedules', 'is_active')) {
                    // Drop is_active and add status
                    $table->dropColumn('is_active');
                    $table->string('status')->default('active')->after('semester');
                } else if (!Schema::hasColumn('schedules', 'status')) {
                    // Add status if it doesn't exist
                    $table->string('status')->default('active')->after('semester');
                }

                if (!Schema::hasColumn('schedules', 'notes')) {
                    $table->text('notes')->nullable()->after('status');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse migration needed as this is a data alignment migration
    }
}; 