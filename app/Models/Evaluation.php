<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'subject_id',
        'semester',
        'academic_year',
        'assessment_score',
        'mid_exam_score',
        'final_exam_score',
        'final_score',
        'grade',
        'teacher_notes',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'assessment_score' => 'decimal:2',
        'mid_exam_score' => 'decimal:2',
        'final_exam_score' => 'decimal:2',
        'final_score' => 'decimal:2',
    ];
    
    /**
     * Get the student that owns the evaluation.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    
    /**
     * Get the subject that owns the evaluation.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
    
    /**
     * Calculate final score based on weighted components.
     * 
     * @return float
     */
    public function calculateFinalScore()
    {
        $assessmentWeight = 0.3; // 30%
        $midExamWeight = 0.3; // 30%
        $finalExamWeight = 0.4; // 40%
        
        if ($this->assessment_score === null || $this->mid_exam_score === null || $this->final_exam_score === null) {
            return null;
        }
        
        return ($this->assessment_score * $assessmentWeight) + 
               ($this->mid_exam_score * $midExamWeight) + 
               ($this->final_exam_score * $finalExamWeight);
    }
    
    /**
     * Determine grade based on final score.
     * 
     * @param float $finalScore
     * @return string
     */
    public function determineGrade($finalScore)
    {
        if ($finalScore === null) {
            return null;
        }
        
        if ($finalScore >= 90) {
            return 'A';
        } elseif ($finalScore >= 80) {
            return 'B';
        } elseif ($finalScore >= 70) {
            return 'C';
        } elseif ($finalScore >= 60) {
            return 'D';
        } else {
            return 'E';
        }
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
