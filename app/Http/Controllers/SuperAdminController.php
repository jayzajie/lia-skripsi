<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware diatur di routes/web.php, jadi tidak perlu di sini
    }

    /**
     * Show the Super Admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard(): View
    {
        // Example data - replace with actual data from your database
        $totalStudents = Student::count() ?? 0;
        $maleStudents = Student::where('gender', 'male')->count() ?? 0;
        $femaleStudents = Student::where('gender', 'female')->count() ?? 0;

        // Get student count by class for chart
        $studentsByClass = [
            Student::where('class_level', 'LIKE', '1%')->count() ?? 0,
            Student::where('class_level', 'LIKE', '2%')->count() ?? 0,
            Student::where('class_level', 'LIKE', '3%')->count() ?? 0,
            Student::where('class_level', 'LIKE', '4%')->count() ?? 0,
            Student::where('class_level', 'LIKE', '5%')->count() ?? 0,
            Student::where('class_level', 'LIKE', '6%')->count() ?? 0,
        ];

        return view('superadmin.dashboard', compact(
            'totalStudents',
            'maleStudents',
            'femaleStudents',
            'studentsByClass'
        ));
    }

    /**
     * Show the students management page.
     *
     * @return \Illuminate\View\View
     */
    public function students(): View
    {
        $students = Student::latest()->paginate(10);
        return view('superadmin.students', compact('students'));
    }

    /**
     * Show the staff management page.
     *
     * @return \Illuminate\View\View
     */
    public function staff(): View
    {
        $staff = User::role('staff')->latest()->paginate(10);
        return view('superadmin.staff', compact('staff'));
    }

    /**
     * Show the activities management page.
     *
     * @return \Illuminate\View\View
     */
    public function activities(): View
    {
        return view('superadmin.activities');
    }

    /**
     * Show the evaluations management page.
     *
     * @return \Illuminate\View\View
     */
    public function evaluations(): View
    {
        return view('superadmin.evaluations');
    }

    /**
     * Show the subjects management page.
     *
     * @return \Illuminate\View\View
     */
    public function subjects(): View
    {
        return view('superadmin.subjects');
    }

    /**
     * Show the schedule management page.
     *
     * @return \Illuminate\View\View
     */
    public function schedule(): View
    {
        return view('superadmin.schedule');
    }
}
