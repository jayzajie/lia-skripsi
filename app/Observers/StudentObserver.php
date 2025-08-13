<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\SchoolClass;

class StudentObserver
{
    /**
     * Handle the Student "created" event.
     */
    public function created(Student $student): void
    {
        $this->updateClassCount($student);
    }

    /**
     * Handle the Student "updated" event.
     */
    public function updated(Student $student): void
    {
        // Update count for old class if class_level changed
        if ($student->isDirty('class_level')) {
            $oldClassLevel = $student->getOriginal('class_level');
            if ($oldClassLevel) {
                $this->updateClassCountByName($oldClassLevel, $student->getOriginal('academic_year'));
            }
        }

        // Update count for current class
        $this->updateClassCount($student);
    }

    /**
     * Handle the Student "deleted" event.
     */
    public function deleted(Student $student): void
    {
        $this->updateClassCount($student);
    }

    /**
     * Update class student count for the student's class.
     */
    private function updateClassCount(Student $student): void
    {
        if ($student->class_level && $student->academic_year) {
            $this->updateClassCountByName($student->class_level, $student->academic_year);
        }
    }

    /**
     * Update class student count by class name and academic year.
     */
    private function updateClassCountByName(string $className, string $academicYear): void
    {
        $class = SchoolClass::where('name', $className)
                           ->where('academic_year', $academicYear)
                           ->first();

        if ($class) {
            $class->updateStudentCount();
        }
    }
}
