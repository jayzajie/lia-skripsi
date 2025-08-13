<?php

namespace App\Observers;

use App\Models\SchoolClass;
use App\Models\Schedule;
use App\Models\Subject;

class SchoolClassObserver
{
    /**
     * Handle the SchoolClass "updated" event.
     */
    public function updated(SchoolClass $schoolClass): void
    {
        // If class name changed, update related schedules and subjects
        if ($schoolClass->isDirty('name')) {
            $oldName = $schoolClass->getOriginal('name');
            $newName = $schoolClass->name;

            // Update schedules
            Schedule::where('class_level', $oldName)
                   ->where('academic_year', $schoolClass->academic_year)
                   ->update(['class_level' => $newName]);

            // Update subjects if they reference specific classes
            Subject::where('class_level', $oldName)
                  ->update(['class_level' => $newName]);
        }
    }

    /**
     * Handle the SchoolClass "deleting" event.
     */
    public function deleting(SchoolClass $schoolClass): void
    {
        // Check if class has students
        if ($schoolClass->current_students > 0) {
            throw new \Exception('Tidak dapat menghapus kelas yang masih memiliki siswa');
        }

        // Delete related schedules
        Schedule::where('class_level', $schoolClass->name)
               ->where('academic_year', $schoolClass->academic_year)
               ->delete();
    }
}
