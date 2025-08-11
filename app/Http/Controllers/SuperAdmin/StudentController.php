<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->has('class') && $request->class != '') {
            $query->where('class_level', $request->class);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('academic_year') && $request->academic_year != '') {
            $query->where('academic_year', $request->academic_year);
        }

        $sortField = $request->input('sort', 'name');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $students = $query->paginate(10)->withQueryString();

        $academicYears = Student::distinct()->pluck('academic_year')->filter()->values();

        return view('superadmin.students', compact('students', 'academicYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'nullable|string|max:50|unique:students,nis',
            'class_level' => 'required|string|max:10',
            'gender' => 'required|string|max:20',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'status' => 'required|string|max:20',
            'academic_year' => 'required|string',
        ]);

        $student = Student::create($validated);

        return redirect()->route('superadmin.students.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('superadmin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('superadmin.students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => ['nullable', 'string', 'max:50', Rule::unique('students')->ignore($student->id)],
            'class_level' => 'required|string|max:10',
            'gender' => 'required|string|max:20',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'status' => 'required|string|max:20',
            'academic_year' => 'required|string',
        ]);

        // Update student
        $student->update($validated);

        return redirect()->route('superadmin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('superadmin.students.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}
