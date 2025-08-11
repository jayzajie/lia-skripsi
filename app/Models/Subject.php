<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'credit_hours',
        'class_level',
        'status',
        'teacher_id',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'credit_hours' => 'integer',
    ];
    
    /**
     * Get the teacher that teaches this subject.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }
    
    /**
     * Get the schedules for this subject.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
    
    /**
     * Get the evaluations for this subject.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }
    
    /**
     * Scope a query to only include active subjects.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    /**
     * Scope a query to filter by class level.
     */
    public function scopeClassLevel($query, $level)
    {
        return $query->where('class_level', $level);
    }
}
