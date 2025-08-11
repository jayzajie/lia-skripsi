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
            if (Schema::hasColumn('subjects', 'class') && !Schema::hasColumn('subjects', 'class_level')) {
                $table->renameColumn('class', 'class_level');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            if (Schema::hasColumn('subjects', 'class_level') && !Schema::hasColumn('subjects', 'class')) {
                $table->renameColumn('class_level', 'class');
            }
        });
    }
};
