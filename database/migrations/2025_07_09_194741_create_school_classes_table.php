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
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., "1A", "2B", "3A"
            $table->integer('grade_level'); // 1, 2, 3, 4, 5, 6
            $table->string('section'); // A, B
            $table->integer('capacity')->default(30); // Maximum students
            $table->integer('current_students')->default(0); // Current number of students
            $table->string('homeroom_teacher')->nullable(); // Wali kelas
            $table->string('academic_year'); // e.g., "2025/2026"
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};
