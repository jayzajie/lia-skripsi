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
        Schema::table('subjects', function (Blueprint $table) {
            if (Schema::hasColumn('subjects', 'credits') && !Schema::hasColumn('subjects', 'credit_hours')) {
                $table->renameColumn('credits', 'credit_hours');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            if (Schema::hasColumn('subjects', 'credit_hours') && !Schema::hasColumn('subjects', 'credits')) {
                $table->renameColumn('credit_hours', 'credits');
            }
        });
    }
};
