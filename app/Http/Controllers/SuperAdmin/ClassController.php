<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of classes with detailed information.
     */
    public function index(Request $request)
    {
        // Get academic years
        $academicYears = SchoolClass::select('academic_year')
                                  ->distinct()
                                  ->orderBy('academic_year', 'desc')
                                  ->pluck('academic_year');

        // Get current academic year from request or default
        $currentAcademicYear = $request->get('year', $academicYears->first() ?? '2026/2027');

        // Get classes grouped by grade level for the selected academic year
        $classes = SchoolClass::with(['teacher'])
                             ->where('academic_year', $currentAcademicYear)
                             ->orderBy('name')
                             ->get();

        $classesByGrade = $classes->groupBy(function($class) {
            // Extract grade level from class name (e.g., "1A" -> 1, "2B" -> 2)
            return (int) substr($class->name, 0, 1);
        });

        // Calculate student statistics
        $totalStudents = Student::where('academic_year', $currentAcademicYear)
                               ->where('status', 'active')
                               ->count();

        $totalCapacity = $classes->sum('capacity');
        $occupiedSlots = $classes->sum('current_students');
        $availableSlots = $totalCapacity - $occupiedSlots;

        $studentStats = [
            [
                'label' => 'Total Siswa',
                'count' => $totalStudents,
                'color' => 'primary'
            ],
            [
                'label' => 'Kapasitas Total',
                'count' => $totalCapacity,
                'color' => 'info'
            ],
            [
                'label' => 'Terisi',
                'count' => $occupiedSlots,
                'color' => 'success'
            ],
            [
                'label' => 'Tersedia',
                'count' => $availableSlots,
                'color' => 'warning'
            ]
        ];

        return view('superadmin.classes.index', compact(
            'classesByGrade',
            'academicYears',
            'currentAcademicYear',
            'studentStats'
        ));
    }
}
