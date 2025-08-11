<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject_id',
        'teacher_id',
        'class_level',
        'day_of_week',
        'start_time',
        'end_time',
        'room',
        'academic_year',
        'semester',
        'status',
        'notes',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];
    
    /**
     * Get the subject associated with the schedule.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
    
    /**
     * Get the teacher associated with the schedule.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }
    
    /**
     * Scope a query to only include active schedules.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    /**
     * Scope a query to filter by day of week.
     */
    public function scopeDay($query, $day)
    {
        return $query->where('day_of_week', $day);
    }
    
    /**
     * Scope a query to filter by class level.
     */
    public function scopeClassLevel($query, $level)
    {
        return $query->where('class_level', $level);
    }
    
    /**
     * Scope a query to filter by academic year.
     */
    public function scopeAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }
    
    /**
     * Scope a query to filter by semester.
     */
    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }
}
