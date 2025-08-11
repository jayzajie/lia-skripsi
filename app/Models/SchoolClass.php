<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'grade_level',
        'section',
        'capacity',
        'current_students',
        'homeroom_teacher',
        'academic_year',
        'description',
        'status'
    ];

    protected $casts = [
        'grade_level' => 'integer',
        'capacity' => 'integer',
        'current_students' => 'integer',
    ];

    // Relationship with students
    public function students()
    {
        return $this->hasMany(Student::class, 'class_level', 'name');
    }

    // Scope for active classes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for specific grade level
    public function scopeGradeLevel($query, $level)
    {
        return $query->where('grade_level', $level);
    }

    // Get homeroom teacher
    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'homeroom_teacher', 'name');
    }

    // Update student count
    public function updateStudentCount()
    {
        $count = Student::where('class_level', $this->name)
                       ->where('academic_year', $this->academic_year)
                       ->where('status', 'active')
                       ->count();

        $this->update(['current_students' => $count]);
        return $count;
    }

    // Check if class has capacity
    public function hasCapacity($additionalStudents = 1)
    {
        return ($this->current_students + $additionalStudents) <= $this->capacity;
    }

    // Get available capacity
    public function getAvailableCapacity()
    {
        return $this->capacity - $this->current_students;
    }

    // Get available capacity
    public function getAvailableCapacityAttribute()
    {
        return $this->capacity - $this->current_students;
    }

    // Check if class is full
    public function getIsFullAttribute()
    {
        return $this->current_students >= $this->capacity;
    }
}
