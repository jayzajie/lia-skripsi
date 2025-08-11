<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SchoolClass::query();

        // Filter by grade level
        if ($request->filled('grade_level')) {
            $query->where('grade_level', $request->grade_level);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by academic year
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        // Search by name or homeroom teacher
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('homeroom_teacher', 'like', "%{$search}%");
            });
        }

        $classes = $query->orderBy('grade_level')
                        ->orderBy('section')
                        ->paginate(10);

        // Update student counts for all classes
        foreach ($classes as $class) {
            $class->updateStudentCount();
        }

        // Get available academic years
        $academicYears = SchoolClass::distinct()->pluck('academic_year')->sort();

        // Get available teachers for homeroom
        $teachers = Staff::pluck('name', 'name');

        return view('superadmin.classes.index', compact('classes', 'academicYears', 'teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get available teachers for homeroom
        $teachers = Staff::pluck('name', 'name');

        return view('superadmin.classes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'grade_level' => 'required|integer|min:1|max:6',
            'section' => 'required|string|max:1',
            'capacity' => 'required|integer|min:1|max:50',
            'homeroom_teacher' => 'nullable|string|max:255',
            'academic_year' => 'required|string|max:9',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive'
        ]);

        // Generate class name
        $name = $request->grade_level . strtoupper($request->section);

        // Check if class already exists for this academic year
        $existingClass = SchoolClass::where('name', $name)
                                   ->where('academic_year', $request->academic_year)
                                   ->first();

        if ($existingClass) {
            return back()->withErrors(['name' => 'Kelas ' . $name . ' sudah ada untuk tahun ajaran ' . $request->academic_year])
                        ->withInput();
        }

        SchoolClass::create([
            'name' => $name,
            'grade_level' => $request->grade_level,
            'section' => strtoupper($request->section),
            'capacity' => $request->capacity,
            'homeroom_teacher' => $request->homeroom_teacher,
            'academic_year' => $request->academic_year,
            'description' => $request->description,
            'status' => $request->status,
            'current_students' => 0
        ]);

        return redirect()->route('superadmin.classes.index')
                        ->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolClass $class)
    {
        // Load students in this class
        $students = Student::where('class_level', $class->name)
                          ->where('academic_year', $class->academic_year)
                          ->paginate(15);

        return view('superadmin.classes.show', compact('class', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $class)
    {
        // Get available teachers for homeroom
        $teachers = Staff::pluck('name', 'name');

        return view('superadmin.classes.edit', compact('class', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'grade_level' => 'required|integer|min:1|max:6',
            'section' => 'required|string|max:1',
            'capacity' => 'required|integer|min:1|max:50',
            'homeroom_teacher' => 'nullable|string|max:255',
            'academic_year' => 'required|string|max:9',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive'
        ]);

        // Generate new class name
        $newName = $request->grade_level . strtoupper($request->section);

        // Check if new class name conflicts with existing classes (except current one)
        if ($newName !== $class->name) {
            $existingClass = SchoolClass::where('name', $newName)
                                       ->where('academic_year', $request->academic_year)
                                       ->where('id', '!=', $class->id)
                                       ->first();

            if ($existingClass) {
                return back()->withErrors(['name' => 'Kelas ' . $newName . ' sudah ada untuk tahun ajaran ' . $request->academic_year])
                            ->withInput();
            }

            // Update students' class if class name changed
            Student::where('class_level', $class->name)
                   ->where('academic_year', $class->academic_year)
                   ->update(['class_level' => $newName]);
        }

        $class->update([
            'name' => $newName,
            'grade_level' => $request->grade_level,
            'section' => strtoupper($request->section),
            'capacity' => $request->capacity,
            'homeroom_teacher' => $request->homeroom_teacher,
            'academic_year' => $request->academic_year,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('superadmin.classes.index')
                        ->with('success', 'Kelas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $class)
    {
        // Check if class has students
        $studentCount = Student::where('class_level', $class->name)
                              ->where('academic_year', $class->academic_year)
                              ->count();

        if ($studentCount > 0) {
            return back()->withErrors(['delete' => 'Tidak dapat menghapus kelas yang masih memiliki siswa. Pindahkan siswa terlebih dahulu.']);
        }

        $class->delete();

        return redirect()->route('superadmin.classes.index')
                        ->with('success', 'Kelas berhasil dihapus!');
    }
}
