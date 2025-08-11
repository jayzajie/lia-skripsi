<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'gender',
        'class_level',
        'student_id',
        'address',
        'phone',
        'parent_name',
        'parent_phone',
        'parent_occupation',
        'birth_place',
        'birth_date',
        'religion',
        'user_id',
        'nis',
        'status',
        'academic_year',
        'is_repeating',
        'promotion_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'is_repeating' => 'boolean',
    ];

    /**
     * Get the user that the student belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the evaluations for this student.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Get the school class for this student.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_level', 'name')
                    ->where('academic_year', $this->academic_year);
    }

    /**
     * Scope for students by grade level.
     */
    public function scopeByGradeLevel($query, $gradeLevel)
    {
        return $query->where('class_level', 'like', $gradeLevel . '%');
    }

    /**
     * Scope for active students.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for repeating students.
     */
    public function scopeRepeating($query)
    {
        return $query->where('is_repeating', true);
    }

    /**
     * Get the grade level number from class_level.
     */
    public function getGradeLevelAttribute()
    {
        return (int) substr($this->class_level, 0, 1);
    }
}
