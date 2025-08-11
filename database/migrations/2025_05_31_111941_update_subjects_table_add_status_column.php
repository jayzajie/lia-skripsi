<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Add status column
            $table->string('status')->default('active')->after('is_active');
            
            // Rename 'class' to 'class_level' to match the model
            $table->renameColumn('class', 'class_level');
            
            // Rename 'credits' to 'credit_hours' to match the model
            $table->renameColumn('credits', 'credit_hours');
        });
        
        // Update existing records to set status based on is_active
        DB::statement("UPDATE subjects SET status = CASE WHEN is_active = 1 THEN 'active' ELSE 'inactive' END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Remove status column
            $table->dropColumn('status');
            
            // Revert column names
            $table->renameColumn('class_level', 'class');
            $table->renameColumn('credit_hours', 'credits');
        });
    }
};
