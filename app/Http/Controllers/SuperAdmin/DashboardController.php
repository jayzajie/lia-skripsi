<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Staff;
use App\Models\User;
use App\Models\Konfirmasi;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the superadmin dashboard.
     */
    public function index()
    {
        // Hitung statistik dinamis
        $totalStudents = Student::count();
        $totalTeachers = Staff::count();
        $totalUsers = User::count();
        $pendingVerifications = Konfirmasi::where('status', 'pending')->count();

        // Statistik kelas dari tabel school_classes
        $totalClasses = SchoolClass::count();
        $activeClasses = SchoolClass::where('status', 'active')->count();
        $inactiveClasses = SchoolClass::where('status', 'inactive')->count();

        // Update student counts untuk semua kelas
        $classes = SchoolClass::all();
        foreach ($classes as $class) {
            $class->updateStudentCount();
        }

        // Statistik siswa per kelas berdasarkan data real
        $studentsByClass = Student::selectRaw('class_level, COUNT(*) as count')
            ->groupBy('class_level')
            ->orderBy('class_level')
            ->get()
            ->pluck('count', 'class_level');

        // Siswa aktif vs tidak aktif
        $activeStudents = Student::where('status', 'active')->count();
        $inactiveStudents = Student::where('status', 'inactive')->count();

        // Data untuk chart - ambil dari kelas yang ada di database
        $allClasses = SchoolClass::orderBy('grade_level')->orderBy('section')->pluck('name')->toArray();
        if (empty($allClasses)) {
            // Fallback jika belum ada kelas di database
            $allClasses = ['1A', '1B', '2A', '2B', '3A', '3B', '4A', '4B', '5A', '5B', '6A', '6B'];
        }

        $classData = [];
        foreach ($allClasses as $class) {
            $classData[$class] = $studentsByClass->get($class, 0);
        }

        // Data detail kelas untuk sidebar
        $classDetails = SchoolClass::with('students')
            ->orderBy('grade_level')
            ->orderBy('section')
            ->get()
            ->map(function ($class) {
                return [
                    'name' => $class->name,
                    'grade_level' => $class->grade_level,
                    'student_count' => $class->current_students,
                    'capacity' => $class->capacity,
                    'homeroom_teacher' => $class->homeroom_teacher,
                    'status' => $class->status
                ];
            });

        return view('superadmin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalUsers',
            'pendingVerifications',
            'totalClasses',
            'activeClasses',
            'inactiveClasses',
            'studentsByClass',
            'activeStudents',
            'inactiveStudents',
            'classData',
            'classDetails'
        ));
    }
}
